<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporte extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();

        $lang      = $this->session->userdata('lang') ?: 'es';
        $idioma_ci = ($lang === 'en') ? 'english' : 'espanol';

        // Idiomas que usa esta vista
        $this->lang->load('reportes_portal', $idioma_ci);
    }

    public function index()
    {
        $datos['candidatos']       = $this->doping_model->getCandidatosSinDoping();
        $datos['paquetes']         = $this->doping_model->getPaquetesAntidoping();
        $datos['clientes']         = $this->funciones_model->getClientesActivos();
        $datos['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
        $data['permisos']          = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos']        = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $notificaciones    = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (! empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }
        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/reportes_index', $datos)
            ->view('adminpanel/footer');
    }
    public function getSubclientes()
    {
        $id_cliente          = $_POST['id_cliente'];
        $data['subclientes'] = $this->reporte_model->getSubclientes($id_cliente);
        $salida              = "<option value=''>Selecciona Subcliente</option>";
        if ($data['subclientes']) {
            $salida .= "<option value='0'>TODOS</option>";
            foreach ($data['subclientes'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            $salida .= "<option value=''>N/A</option>";
            echo $salida;
        }
    }
    public function getProyectos()
    {
        $id_cliente        = $_POST['id_cliente'];
        $data['proyectos'] = $this->doping_model->getProyectos($id_cliente);
        $salida            = "<option value=''>Selecciona Proyecto</option>";
        if ($data['proyectos']) {
            $salida .= "<option value='0'>TODOS</option>";
            foreach ($data['proyectos'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            $salida .= "<option value=''>N/A</option>";
            echo $salida;
        }
    }
    public function reporteDopingFinalizados()
    {
        $f_inicio   = fecha_espanol_bd($_POST['fi']);
        $f_fin      = fecha_espanol_bd($_POST['ff']);
        $cliente    = $_POST['cliente'];
        $subcliente = $_POST['subcliente'];
        $proyecto   = $_POST['proyecto'];
        $resultado  = $_POST['res'];
        $lab        = $_POST['lab'];

        $data['datos'] = $this->reporte_model->reporteDopingFinalizados($f_inicio, $f_fin, $cliente, $subcliente, $proyecto, $resultado, $lab);
        //var_dump($data['datos']);
        if ($data['datos']) {
            $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteDopingFinalizados_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $subcliente . '_' . $proyecto . '_' . $resultado . '_' . $lab . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
            $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
            $salida .= '<tr>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha doping</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Nombre</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Cliente</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Subcliente</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Proyecto</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Examen</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Código</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha resultado</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Resultado</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Laboratorio</th>';
            $salida .= '</tr>';
            foreach ($data['datos'] as $row) {
                $subcliente  = ($row->subcliente != "" && $row->subcliente != null) ? $row->subcliente : "-";
                $proyecto    = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                $f_doping    = $this->reporteFecha($row->fecha_doping);
                $f_resultado = ($row->fecha_resultado != "" && $row->fecha_resultado != null) ? $this->reporteFecha($row->fecha_resultado) : "Sin resultado";
                $res         = ($row->resultado == 1) ? "Positivo" : "Negativo";
                $salida .= "<tr><tbody>";
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_doping . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $subcliente . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $proyecto . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->parametros . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->codigo_prueba . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_resultado . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $res . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->laboratorio . '</td>';
                $salida .= "</tbody></tr>";
            }
            $salida .= "</table>";
        } else {
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
        }
        echo $salida;
    }
    public function reporteDopingFinalizados_Excel()
    {
        $datos         = $this->uri->segment(3);
        $dato          = explode('_', $datos);
        $f_inicio      = $dato[0];
        $f_fin         = $dato[1];
        $cliente       = $dato[2];
        $subcliente    = $dato[3];
        $proyecto      = $dato[4];
        $resultado     = $dato[5];
        $lab           = $dato[6];
        $data['datos'] = $this->reporte_model->reporteDopingFinalizados($f_inicio, $f_fin, $cliente, $subcliente, $proyecto, $resultado, $lab);
        if ($data['datos']) {
            //Se crea objeto de la clase.
            $excel = new Spreadsheet();
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            //Le aplicamos negrita a los títulos de la cabecera.
            $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
            //Definimos los títulos de la cabecera.
            $excel->getActiveSheet()->setCellValue("A{$contador}", 'FECHA DOPING');
            $excel->getActiveSheet()->setCellValue("B{$contador}", 'NOMBRE');
            $excel->getActiveSheet()->setCellValue("C{$contador}", 'CLIENTE');
            $excel->getActiveSheet()->setCellValue("D{$contador}", 'SUBCLIENTE');
            $excel->getActiveSheet()->setCellValue("E{$contador}", 'PROYECTO');
            $excel->getActiveSheet()->setCellValue("F{$contador}", 'EXAMEN');
            $excel->getActiveSheet()->setCellValue("G{$contador}", 'CÓDIGO');
            $excel->getActiveSheet()->setCellValue("H{$contador}", 'FECHA RESULTADO');
            $excel->getActiveSheet()->setCellValue("I{$contador}", 'RESULTADO');
            $excel->getActiveSheet()->setCellValue("J{$contador}", 'LABORATORIO');
            //Definimos la data del cuerpo.
            foreach ($data['datos'] as $row) {
                $subcliente  = ($row->subcliente != "" && $row->subcliente != null) ? $row->subcliente : "-";
                $proyecto    = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                $f_doping    = $this->reporteFecha($row->fecha_doping);
                $f_resultado = ($row->fecha_resultado != "" && $row->fecha_resultado != null) ? $this->reporteFecha($row->fecha_resultado) : "Sin resultado";
                $res         = ($row->resultado == 1) ? "Positivo" : "Negativo";
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_doping);
                $excel->getActiveSheet()->setCellValue("B{$contador}", $row->candidato);
                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->cliente);
                $excel->getActiveSheet()->setCellValue("D{$contador}", $subcliente);
                $excel->getActiveSheet()->setCellValue("E{$contador}", $proyecto);
                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->parametros);
                $excel->getActiveSheet()->setCellValue("G{$contador}", $row->codigo_prueba);
                $excel->getActiveSheet()->setCellValue("H{$contador}", $f_resultado);
                $excel->getActiveSheet()->setCellValue("I{$contador}", $res);
                $excel->getActiveSheet()->setCellValue("J{$contador}", $row->laboratorio);
            }
                                                               //Creamos objeto para crear el archivo y definimos un nombre de archivo
            $writer   = new Xlsx($excel);                      // instantiate Xlsx
            $filename = 'Reporte1_RegistrosDopingFinalizados'; // set filename for excel file to be exported
                                                               //Cabeceras
            header('Content-Type: application/vnd.ms-excel');  // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
        }
        /*else{
            $contador = 2;
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
        }*/
    }
    public function reporteEstudiosFinalizados()
    {
        $f_inicio = fecha_espanol_bd($_POST['fi']);
        $f_fin    = fecha_espanol_bd($_POST['ff']);
        $cliente  = $_POST['cliente'];
        $usuario  = $_POST['usuario'];

        $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteEstudiosFinalizados_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $usuario . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
        $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
        $salida .= '<tr>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha alta</th>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha finalizado</th>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Analista</th>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Candidato</th>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Cliente</th>';
        $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">SLA</th>';
        $salida .= '</tr>';
        $salida .= "<tbody>";

        if ($usuario == 0) {
            $data['usuarios'] = $this->reporte_model->getUsuarios();
            foreach ($data['usuarios'] as $user) {
                if ($cliente == 0) {
                    $data['data'] = $this->reporte_model->getClientes();
                    foreach ($data['data'] as $cl) {
                        if ($cl->id == 1 || $cl->id == 2) {
                            $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos1']) {
                                foreach ($data['datos1'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        } elseif ($cl->id == 3 || $cl->id == 77) {
                            $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos2']) {
                                foreach ($data['datos2'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo_parcial . ' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        } else {
                            $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos3']) {
                                foreach ($data['datos3'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        }

                    }

                } else {
                    if ($cliente == 1 || $cliente == 2) {
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos1']) {
                            foreach ($data['datos1'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                $salida .= '</tr>';
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } elseif ($cliente == 3 || $cliente == 77) {
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos2']) {
                            foreach ($data['datos2'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo_parcial . ' días</td>';
                                $salida .= '</tr>';

                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } else {
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos3']) {
                            foreach ($data['datos3'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                $salida .= '</tr>';

                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    }
                }
            }
            $salida .= "</tbody>";
            $salida .= "</table>";
        } else {
            if ($cliente == 0) {
                $data['data'] = $this->reporte_model->getClientes();
                foreach ($data['data'] as $cl) {
                    if ($cl->id == 1 || $cl->id == 2) {
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos1']) {
                            foreach ($data['datos1'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                $salida .= '</tr>';
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } elseif ($cl->id == 3 || $cl->id == 77) {
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos2']) {
                            foreach ($data['datos2'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo_parcial . ' días</td>';
                                $salida .= '</tr>';

                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } else {
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos3']) {
                            foreach ($data['datos3'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                                $salida .= '</tr>';

                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    }
                }
                $salida .= "</tbody></tr>";
                $salida .= "</table>";
            } else {
                if ($cliente == 1 || $cliente == 2) {
                    $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos1']) {
                        foreach ($data['datos1'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                            $salida .= '</tr>';
                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                } elseif ($cliente == 3 || $cliente == 77) {
                    $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos2']) {
                        foreach ($data['datos2'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo_parcial . ' días</td>';
                            $salida .= '</tr>';

                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                } else {
                    $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos3']) {
                        foreach ($data['datos3'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->usuario . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->tiempo . ' días</td>';
                            $salida .= '</tr>';

                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                }
            }
        }

        echo $salida;
    }
    public function reporteEstudiosFinalizados_Excel()
    {
        $datos    = $this->uri->segment(3);
        $dato     = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin    = $dato[1];
        $cliente  = $dato[2];
        $usuario  = $dato[3];
        $salida   = '';
        //Se crea objeto de la clase.
        $excel = new Spreadsheet();
        //Contador de filas
        $contador = 1;
        //Le aplicamos ancho las columnas.
        // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
        //Le aplicamos ancho las columnas.
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        //Le aplicamos negrita a los títulos de la cabecera.
        $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
        $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);

        //Definimos los títulos de la cabecera.
        $excel->getActiveSheet()->setCellValue("A{$contador}", 'FECHA ALTA');
        $excel->getActiveSheet()->setCellValue("B{$contador}", 'FECHA FINALIZADO');
        $excel->getActiveSheet()->setCellValue("C{$contador}", 'ANALISTA');
        $excel->getActiveSheet()->setCellValue("D{$contador}", 'CANDIDATO');
        $excel->getActiveSheet()->setCellValue("E{$contador}", 'CLIENTE');
        $excel->getActiveSheet()->setCellValue("F{$contador}", 'SLA');

        if ($usuario == 0) {
            $data['usuarios'] = $this->reporte_model->getUsuarios();
            foreach ($data['usuarios'] as $user) {
                if ($cliente == 0) {
                    $data['data'] = $this->reporte_model->getClientes();
                    foreach ($data['data'] as $cl) {
                        if ($cl->id == 1 || $cl->id == 2) {
                            $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos1']) {
                                foreach ($data['datos1'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    //Incrementamos una fila más, para ir a la siguiente.
                                    $contador++;
                                    $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                    $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                    $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                    $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                    $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                    $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        } elseif ($cl->id == 3 || $cl->id == 77) {
                            $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos2']) {
                                foreach ($data['datos2'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    //Incrementamos una fila más, para ir a la siguiente.
                                    $contador++;
                                    $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                    $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                    $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                    $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                    $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                    $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo_parcial);
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        } else {
                            $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $user->id);
                            if ($data['datos3']) {
                                foreach ($data['datos3'] as $row) {
                                    $f_alta  = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    //Incrementamos una fila más, para ir a la siguiente.
                                    $contador++;
                                    $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                    $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                    $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                    $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                    $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                    $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                                }
                                $band = 0;
                            } else {
                                $band = 1;
                            }
                        }

                    }

                } else {
                    if ($cliente == 1 || $cliente == 2) {
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos1']) {
                            foreach ($data['datos1'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } elseif ($cliente == 3 || $cliente == 77) {
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos2']) {
                            foreach ($data['datos2'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo_parcial);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } else {
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $user->id);
                        if ($data['datos3']) {
                            foreach ($data['datos3'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    }
                }
            }
            $salida .= "</tbody>";
            $salida .= "</table>";
        } else {
            if ($cliente == 0) {
                $data['data'] = $this->reporte_model->getClientes();
                foreach ($data['data'] as $cl) {
                    if ($cl->id == 1 || $cl->id == 2) {
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos1']) {
                            foreach ($data['datos1'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } elseif ($cl->id == 3 || $cl->id == 77) {
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos2']) {
                            foreach ($data['datos2'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo_parcial);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    } else {
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $usuario);
                        if ($data['datos3']) {
                            foreach ($data['datos3'] as $row) {
                                $f_alta  = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                //Incrementamos una fila más, para ir a la siguiente.
                                $contador++;
                                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                                $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                                $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                                $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                            }
                            $band = 0;
                        } else {
                            $band = 1;
                        }
                    }
                }
                $salida .= "</tbody></tr>";
                $salida .= "</table>";
            } else {
                if ($cliente == 1 || $cliente == 2) {
                    $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos1']) {
                        foreach ($data['datos1'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            //Incrementamos una fila más, para ir a la siguiente.
                            $contador++;
                            $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                            $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                            $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                            $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                            $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                            $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                } elseif ($cliente == 3 || $cliente == 77) {
                    $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos2']) {
                        foreach ($data['datos2'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            //Incrementamos una fila más, para ir a la siguiente.
                            $contador++;
                            $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                            $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                            $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                            $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                            $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                            $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo_parcial);
                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                } else {
                    $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $usuario);
                    if ($data['datos3']) {
                        foreach ($data['datos3'] as $row) {
                            $f_alta  = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            //Incrementamos una fila más, para ir a la siguiente.
                            $contador++;
                            $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                            $excel->getActiveSheet()->setCellValue("B{$contador}", $f_final);
                            $excel->getActiveSheet()->setCellValue("C{$contador}", $row->usuario);
                            $excel->getActiveSheet()->setCellValue("D{$contador}", $row->candidato);
                            $excel->getActiveSheet()->setCellValue("E{$contador}", $row->cliente);
                            $excel->getActiveSheet()->setCellValue("F{$contador}", $row->tiempo);
                        }
                        $band = 0;
                    } else {
                        $band = 1;
                    }
                }
            }
        }
                                                          //Creamos objeto para crear el archivo y definimos un nombre de archivo
        $writer   = new Xlsx($excel);                     // instantiate Xlsx
        $filename = 'Reporte2_RegistrosESEFinalizados';   // set filename for excel file to be exported
                                                          //Cabeceras
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file
    }
    public function reporteDopingGeneral()
    {
        $f_inicio   = fecha_espanol_bd($_POST['fi']);
        $f_fin      = fecha_espanol_bd($_POST['ff']);
        $cliente    = $_POST['cliente'];
        $subcliente = $_POST['subcliente'];
        $proyecto   = $_POST['proyecto'];

        $data['datos'] = $this->reporte_model->reporteDopingGeneral($f_inicio, $f_fin, $cliente, $subcliente, $proyecto);
        //var_dump($data['datos']);
        if ($data['datos']) {
            $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteDopingGeneral_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $subcliente . '_' . $proyecto . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
            $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
            $salida .= '<tr>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha registro</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Nombre</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Cliente</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Subcliente</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Proyecto</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Examen</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Código</th>';
            $salida .= '</tr>';
            foreach ($data['datos'] as $row) {
                $subcliente = ($row->subcliente != "" && $row->subcliente != null) ? $row->subcliente : "-";
                $proyecto   = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                $f_doping   = $this->reporteFecha($row->creacion);
                $salida .= "<tr><tbody>";
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_doping . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $subcliente . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $proyecto . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->parametros . '</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->codigo_prueba . '</td>';
                $salida .= "</tbody></tr>";
            }
            $salida .= "</table>";
        } else {
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
        }
        echo $salida;
    }
    public function reporteDopingGeneral_Excel()
    {
        $datos      = $this->uri->segment(3);
        $dato       = explode('_', $datos);
        $f_inicio   = $dato[0];
        $f_fin      = $dato[1];
        $cliente    = $dato[2];
        $subcliente = $dato[3];
        $proyecto   = $dato[4];
        //var_dump($datos);
        $data['datos'] = $this->reporte_model->reporteDopingGeneral($f_inicio, $f_fin, $cliente, $subcliente, $proyecto);
        if ($data['datos']) {
            //Se crea objeto de la clase.
            $excel = new Spreadsheet();
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
            //Le aplicamos ancho las columnas.
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

            //Le aplicamos negrita a los títulos de la cabecera.
            $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);

            //Definimos los títulos de la cabecera.
            $excel->getActiveSheet()->setCellValue("A{$contador}", 'FECHA REGISTRO');
            $excel->getActiveSheet()->setCellValue("B{$contador}", 'NOMBRE');
            $excel->getActiveSheet()->setCellValue("C{$contador}", 'CLIENTE');
            $excel->getActiveSheet()->setCellValue("D{$contador}", 'SUBCLIENTE');
            $excel->getActiveSheet()->setCellValue("E{$contador}", 'PROYECTO');
            $excel->getActiveSheet()->setCellValue("F{$contador}", 'EXAMEN');
            $excel->getActiveSheet()->setCellValue("G{$contador}", 'CÓDIGO');

            //Definimos la data del cuerpo.
            foreach ($data['datos'] as $row) {
                $subcliente = ($row->subcliente != "" && $row->subcliente != null) ? $row->subcliente : "-";
                $proyecto   = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                $f_doping   = $this->reporteFecha($row->creacion);
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_doping);
                $excel->getActiveSheet()->setCellValue("B{$contador}", $row->candidato);
                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->cliente);
                $excel->getActiveSheet()->setCellValue("D{$contador}", $subcliente);
                $excel->getActiveSheet()->setCellValue("E{$contador}", $proyecto);
                $excel->getActiveSheet()->setCellValue("F{$contador}", $row->parametros);
                $excel->getActiveSheet()->setCellValue("G{$contador}", $row->codigo_prueba);
            }
                                                              //Creamos objeto para crear el archivo y definimos un nombre de archivo
            $writer   = new Xlsx($excel);                     // instantiate Xlsx
            $filename = 'Reporte3_RegistrosDopinGeneral';     // set filename for excel file to be exported
                                                              //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
        }
        /*else{
            $contador = 2;
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
        }*/
    }
    public function reporteFecha($date)
    {
        $f     = explode(' ', $date);
        $aux   = explode('-', $f[0]);
        $fecha = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $fecha .= " " . $f[1];
        return $fecha;
    }
    public function getFechaNacimiento()
    {
        $id_candidato = $_POST['id_candidato'];
        $f            = $this->doping_model->getFechaNacimiento($id_candidato);
        if ($f->fecha_nacimiento != "") {
            $aux         = explode('-', $f->fecha_nacimiento);
            $fnacimiento = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
            echo $fnacimiento;
        } else {
            echo $fnacimiento = "";
        }
    }

    /*----------------------------------------*/
    /*  Estudios
    /*----------------------------------------*/
    public function listado_estudios_index()
    {
        $datos['clientes']  = $this->funciones_model->getClientesActivos();
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios']  = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/listado_estudios', $datos)
            ->view('adminpanel/footer');
    }
    public function reporteListadoEstudios()
    {
        $this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
        $this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $f_inicio = fecha_espanol_bd($this->input->post('fi'));
            $f_fin    = fecha_espanol_bd($this->input->post('ff'));
            $cliente  = $this->input->post('cliente');
            $res      = $this->input->post('resultado');
            $estatus  = $this->input->post('estatus');
            //$centro_costo = $this->input->post('centro_costo');

            $diaInicio = new DateTime($f_inicio);
            $diaFinal  = new DateTime($f_fin);
            if ($diaInicio > $diaFinal) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Fechas a filtrar no son válidas',
                ];
            } else {
                $data['datos'] = $this->reporte_model->reporteListadoEstudios($f_inicio, $f_fin, $cliente, $res, $estatus);
                // if($centro_costo == 'true'){
                //   $encabezado .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Centro de costo</th>';
                // }
                if ($data['datos']) {
                    $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteListadoEstudios_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $res . '_' . $estatus . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
                    $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
                    $salida .= '<tr>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha Alta</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Candidato</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Empresa</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Proveedor/Reclutador</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Proyecto</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Estatus actual</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Resultado</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha de Resultado</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Centro de costo</th>';
                    $salida .= '</tr>';
                    foreach ($data['datos'] as $row) {
                        $f_alta      = ($row->fecha_alta != null) ? fecha_sinhora_espanol_bd($row->fecha_alta) : '-';
                        $subcliente  = ($row->subcliente != null) ? $row->subcliente : '-';
                        $centroCosto = ($row->centro_costo != null) ? $row->centro_costo : '-';
                        if ($row->proyecto != null) {
                            $proyecto = $row->proyecto;
                        } else {
                            if ($cliente == 1) {
                                $proyecto = 'FACIS';
                            } else {
                                $proyecto = '';
                            }

                        }
                        switch ($row->status) {
                            case 0:
                            case 1:
                                $estatus = 'EN PROCESO';
                                $f_final = '-';
                                break;
                            case 2:
                                if ($row->fechaFinal != null) {
                                    $estatus = 'FINALIZADO';
                                    $f_final = fecha_sinhora_espanol_bd($row->fechaFinal);
                                }
                                if ($row->fechaBGC != null) {
                                    $estatus = 'FINALIZADO';
                                    $f_final = fecha_sinhora_espanol_bd($row->fechaBGC);
                                }
                                if ($row->fechaFinal == null && $row->fechaBGC == null) {
                                    $estatus = 'EN PROCESO';
                                    $f_final = '-';
                                }
                                break;
                        }
                        switch ($row->status_bgc) {
                            case 1:
                                $bgc = 'RECOMENDABLE';
                                break;
                            case 2:
                                $bgc = 'NO RECOMENDABLE';
                                break;
                            case 3:
                                $bgc = 'A CONSIDERACIÓN';
                                break;
                            case 4:
                                $bgc = 'REFERENCIAS VALIDADAS';
                                break;
                            case 5:
                                $bgc = 'REFERENCIAS CON INCONSISTENCIAS';
                                break;
                            default:
                                $bgc = 'NO FINALIZADO';
                                break;
                        }
                        //
                        $salida .= "<tr><tbody>";
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $subcliente . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $proyecto . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $estatus . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $bgc . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $centroCosto . '</td>';
                        $salida .= "</tbody></tr>";
                    }
                    $salida .= "</table>";
                } else {
                    $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida,
                ];
            }

        }
        echo json_encode($msj);
    }
    public function reporteListadoEstudios_Excel()
    {
        $datos    = $this->uri->segment(3);
        $dato     = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin    = $dato[1];
        $cliente  = $dato[2];
        $res      = $dato[3];
        $estatus  = $dato[4];

        $data['datos'] = $this->reporte_model->reporteListadoEstudios($f_inicio, $f_fin, $cliente, $res, $estatus);

        if ($data['datos']) {
            //Se crea objeto de la clase.
            $excel = new Spreadsheet();
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
            //Le aplicamos ancho las columnas.
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(35);

            //Le aplicamos negrita a los títulos de la cabecera.
            $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);

            //Definimos los títulos de la cabecera.
            $excel->getActiveSheet()->setCellValue("A{$contador}", 'Fecha alta');
            $excel->getActiveSheet()->setCellValue("B{$contador}", 'Candidato');
            $excel->getActiveSheet()->setCellValue("C{$contador}", 'Empresa');
            $excel->getActiveSheet()->setCellValue("D{$contador}", 'Proveedor/Reclutador');
            $excel->getActiveSheet()->setCellValue("E{$contador}", 'Proyecto');
            $excel->getActiveSheet()->setCellValue("F{$contador}", 'Estatus actual');
            $excel->getActiveSheet()->setCellValue("G{$contador}", 'Resultado');
            $excel->getActiveSheet()->setCellValue("H{$contador}", 'Fecha de Resultado');
            $excel->getActiveSheet()->setCellValue("I{$contador}", 'Centro de costo');

            //Definimos la data del cuerpo.
            foreach ($data['datos'] as $row) {
                $f_alta      = ($row->fecha_alta != null) ? fecha_sinhora_espanol_bd($row->fecha_alta) : '-';
                $subcliente  = ($row->subcliente != null) ? $row->subcliente : '-';
                $centroCosto = ($row->centro_costo != null) ? $row->centro_costo : '-';
                if ($row->proyecto != null) {
                    $proyecto = $row->proyecto;
                } else {
                    if ($cliente == 1) {
                        $proyecto = 'FACIS';
                    } else {
                        $proyecto = '';
                    }

                }
                switch ($row->status) {
                    case 0:
                    case 1:
                        $estatus = 'EN PROCESO';
                        $f_final = '-';
                        break;
                    case 2:
                        $estatus = 'FINALIZADO';
                        if ($row->fechaFinal != null) {
                            $f_final = fecha_sinhora_espanol_bd($row->fechaFinal);
                        }
                        if ($row->fechaBGC != null) {
                            $f_final = fecha_sinhora_espanol_bd($row->fechaBGC);
                        }
                        break;
                }
                switch ($row->status_bgc) {
                    case 1:
                        $bgc = 'RECOMENDABLE';
                        break;
                    case 2:
                        $bgc = 'NO RECOMENDABLE';
                        break;
                    case 3:
                        $bgc = 'A CONSIDERACIÓN';
                        break;
                    case 4:
                        $bgc = 'REFERENCIAS VALIDADAS';
                        break;
                    case 5:
                        $bgc = 'REFERENCIAS CON INCONSISTENCIAS';
                        break;
                    default:
                        $bgc = 'NO FINALIZADO';
                        break;
                }
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $excel->getActiveSheet()->setCellValue("A{$contador}", $f_alta);
                $excel->getActiveSheet()->setCellValue("B{$contador}", $row->candidato);
                $excel->getActiveSheet()->setCellValue("C{$contador}", $row->cliente);
                $excel->getActiveSheet()->setCellValue("D{$contador}", $subcliente);
                $excel->getActiveSheet()->setCellValue("E{$contador}", $proyecto);
                $excel->getActiveSheet()->setCellValue("F{$contador}", $estatus);
                $excel->getActiveSheet()->setCellValue("G{$contador}", $bgc);
                $excel->getActiveSheet()->setCellValue("H{$contador}", $f_final);
                $excel->getActiveSheet()->setCellValue("I{$contador}", $centroCosto);
            }
                                                              //Creamos objeto para crear el archivo y definimos un nombre de archivo
            $writer   = new Xlsx($excel);                     // instantiate Xlsx
            $filename = 'Reporte_Estudios';                   // set filename for excel file to be exported
                                                              //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
        }
    }
    /*----------------------------------------*/
    /*  SLA
    /*----------------------------------------*/
    public function sla_ingles_index()
    {
        $datos['clientes']  = $this->funciones_model->getClientesInglesActivos();
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios']  = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/sla_ingles', $datos)
            ->view('adminpanel/footer');
    }
    public function reporteSLAIngles()
    {
        $this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
        $this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');
        $this->form_validation->set_rules('finalizado', '¿Se requiere proceso finalizado?', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $f_inicio   = fecha_espanol_bd($this->input->post('fi'));
            $f_fin      = fecha_espanol_bd($this->input->post('ff'));
            $cliente    = $this->input->post('cliente');
            $finalizado = $this->input->post('finalizado');

            $diaInicio = new DateTime($f_inicio);
            $diaFinal  = new DateTime($f_fin);
            if ($diaInicio > $diaFinal) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Fechas a filtrar no son válidas',
                ];
            } else {
                $data['datos'] = $this->reporte_model->reporteSLAIngles($f_inicio, $f_fin, $cliente, $finalizado);
                if ($data['datos']) {
                    $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteSLAIngles_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $finalizado . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
                    $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
                    $salida .= '<tr>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Company</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Candidate</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Register date</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Form date</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Documentation date</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Start date</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Finished date</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Process days</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Status</th>';
                    $salida .= '</tr>';
                    foreach ($data['datos'] as $row) {
                        $proyecto = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                        $f_alta   = ($row->fecha_alta != null) ? fecha_sinhora_ingles_front($row->fecha_alta) : '-';
                        $f_form   = ($row->fecha_contestado != null) ? fecha_sinhora_ingles_front($row->fecha_contestado) : '-';
                        $f_docs   = ($row->fecha_documentos != null) ? fecha_sinhora_ingles_front($row->fecha_documentos) : '-';
                        $f_inicio = ($row->fecha_inicio != null) ? fecha_sinhora_ingles_front($row->fecha_inicio) : '-';
                        $f_final  = ($row->fecha_final != null) ? fecha_sinhora_ingles_front($row->fecha_final) : '-';
                        $res      = ($row->status == 2) ? 'Finished' : "In process";
                        //Calculo de dias transcurridos o SLA
                        $dias           = 0;
                        $acum           = 0;
                        $fecha_registro = ($row->fecha_inicio != null) ? $row->fecha_inicio : $row->fecha_alta; //alta del candidato o fecha inicio del proceso
                        $alta           = explode(' ', $fecha_registro);
                        $fecha_fija     = $alta[0] . ' 16:00:00'; //hora limite para iniciar el contador de dias en 1
                        $fr             = strtotime($fecha_registro);
                        $ff             = strtotime($fecha_fija);
                        if ($fr < $ff) {
                            $dias = 1; //Si la fecha de registro es menor a la hora limite se inicia el dia en 1
                        }
                        $data['festivas'] = $this->funciones_model->getFechasFestivas();
                        //Verificacion del contador de dias con la fecha de regitro
                        $num_dia = date('N', $fr);
                        if ($num_dia != 6 && $num_dia != 7) { //Se evalua si el registro no fue hecho un sabado o domingo
                            $f_aux = strtotime($alta[0]);
                            foreach ($data['festivas'] as $festiva) {
                                $aux           = explode(' ', $festiva->fecha);
                                $fecha_festiva = strtotime($aux[0]); //Se extraen o definen los dias festivos
                                if ($f_aux == $fecha_festiva) {      //Se evalua si cada fecha festiva es diferente a la fecha de regitro
                                    $dias = 0;
                                    break;
                                }
                            }
                        }
                        $fecha_final = $row->fecha_final; //la fecha final es la fecha de creacion de la tabla candidato_bgc
                                                          //Se consulta si existe registro del candidato en la tabla candidato_bgc
                        if ($fecha_final != null) {
                            $fin   = explode(' ', $fecha_final);
                            $date1 = new DateTime($alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                            $date2 = new DateTime($fin[0]);  //fecha final
                            $diff  = $date1->diff($date2);
                            if ($diff->days != 0) {
                                for ($i = 1; $i <= $diff->days; $i++) {
                                    $acum      = 0;
                                    $siguiente = date("Y-m-d", strtotime(date($alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
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
                            }
                        } else {                         //Sin fecha de finalizacion de estudio
                            $date1 = new DateTime($alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                            $date2 = new DateTime();         //fecha actual
                            $date2->format('d/m/Y');
                            $diff = $date1->diff($date2);
                            if ($diff->days != 0) {
                                for ($i = 1; $i <= $diff->days; $i++) {
                                    $acum      = 0;
                                    $siguiente = date("Y-m-d", strtotime(date($alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
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
                            }
                        }
                        //
                        $salida .= "<tr><tbody>";
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_form . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_docs . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_inicio . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_final . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $dias . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $res . '</td>';
                        $salida .= "</tbody></tr>";
                    }
                    $salida .= "</table>";
                } else {
                    $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida,
                ];
            }
        }
        echo json_encode($msj);
    }
    public function reporteSLAIngles_Excel()
    {
        $datos      = $this->uri->segment(3);
        $dato       = explode('_', $datos);
        $f_inicio   = $dato[0];
        $f_fin      = $dato[1];
        $cliente    = $dato[2];
        $finalizado = $dato[3];

        $data['datos'] = $this->reporte_model->reporteSLAIngles($f_inicio, $f_fin, $cliente, $finalizado);
        if ($data['datos']) {
            //Se crea objeto de la clase.
            $excel = new Spreadsheet();
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
            //Le aplicamos ancho las columnas.
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

            //Le aplicamos negrita a los títulos de la cabecera.
            $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);

            //Definimos los títulos de la cabecera.
            $excel->getActiveSheet()->setCellValue("A{$contador}", 'COMPANY');
            $excel->getActiveSheet()->setCellValue("B{$contador}", 'CANDIDATE');
            $excel->getActiveSheet()->setCellValue("C{$contador}", 'REGISTER DATE');
            $excel->getActiveSheet()->setCellValue("D{$contador}", 'FORM DATE');
            $excel->getActiveSheet()->setCellValue("E{$contador}", 'DOCUMENTATION DATE');
            $excel->getActiveSheet()->setCellValue("F{$contador}", 'START DATE');
            $excel->getActiveSheet()->setCellValue("G{$contador}", 'FINISHED DATE');
            $excel->getActiveSheet()->setCellValue("H{$contador}", 'PROCESS DAYS');
            $excel->getActiveSheet()->setCellValue("I{$contador}", 'STATUS');

            //Definimos la data del cuerpo.
            foreach ($data['datos'] as $row) {
                $proyecto = ($row->proyecto != "" && $row->proyecto != null) ? $row->proyecto : "-";
                $f_alta   = ($row->fecha_alta != null) ? fecha_sinhora_ingles_front($row->fecha_alta) : '-';
                $f_form   = ($row->fecha_contestado != null) ? fecha_sinhora_ingles_front($row->fecha_contestado) : '-';
                $f_docs   = ($row->fecha_documentos != null) ? fecha_sinhora_ingles_front($row->fecha_documentos) : '-';
                $f_inicio = ($row->fecha_inicio != null) ? fecha_sinhora_ingles_front($row->fecha_inicio) : '-';
                $f_final  = ($row->fecha_final != null) ? fecha_sinhora_ingles_front($row->fecha_final) : '-';
                $res      = ($row->status == 2) ? 'Finished' : "In process";
                //Calculo de dias transcurridos o SLA
                $dias           = 0;
                $acum           = 0;
                $fecha_registro = ($row->fecha_inicio != null) ? $row->fecha_inicio : $row->fecha_alta; //alta del candidato o fecha inicio del proceso
                $alta           = explode(' ', $fecha_registro);
                $fecha_fija     = $alta[0] . ' 16:00:00'; //hora limite para iniciar el contador de dias en 1
                $fr             = strtotime($fecha_registro);
                $ff             = strtotime($fecha_fija);
                if ($fr < $ff) {
                    $dias = 1; //Si la fecha de registro es menor a la hora limite se inicia el dia en 1
                }
                $data['festivas'] = $this->funciones_model->getFechasFestivas();
                //Verificacion del contador de dias con la fecha de regitro
                $num_dia = date('N', $fr);
                if ($num_dia != 6 && $num_dia != 7) { //Se evalua si el registro no fue hecho un sabado o domingo
                    $f_aux = strtotime($alta[0]);
                    foreach ($data['festivas'] as $festiva) {
                        $aux           = explode(' ', $festiva->fecha);
                        $fecha_festiva = strtotime($aux[0]); //Se extraen o definen los dias festivos
                        if ($f_aux == $fecha_festiva) {      //Se evalua si cada fecha festiva es diferente a la fecha de regitro
                            $dias = 0;
                            break;
                        }
                    }
                }
                $fecha_final = $row->fecha_final; //la fecha final es la fecha de creacion de la tabla candidato_bgc
                                                  //Se consulta si existe registro del candidato en la tabla candidato_bgc
                if ($fecha_final != null) {
                    $fin   = explode(' ', $fecha_final);
                    $date1 = new DateTime($alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                    $date2 = new DateTime($fin[0]);  //fecha final
                    $diff  = $date1->diff($date2);
                    if ($diff->days != 0) {
                        for ($i = 1; $i <= $diff->days; $i++) {
                            $acum      = 0;
                            $siguiente = date("Y-m-d", strtotime(date($alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
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
                    }
                } else {                         //Sin fecha de finalizacion de estudio
                    $date1 = new DateTime($alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                    $date2 = new DateTime();         //fecha actual
                    $date2->format('d/m/Y');
                    $diff = $date1->diff($date2);
                    if ($diff->days != 0) {
                        for ($i = 1; $i <= $diff->days; $i++) {
                            $acum      = 0;
                            $siguiente = date("Y-m-d", strtotime(date($alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
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
                    }
                }
                //
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $excel->getActiveSheet()->setCellValue("A{$contador}", $row->cliente);
                $excel->getActiveSheet()->setCellValue("B{$contador}", $row->candidato);
                $excel->getActiveSheet()->setCellValue("C{$contador}", $f_alta);
                $excel->getActiveSheet()->setCellValue("D{$contador}", $f_form);
                $excel->getActiveSheet()->setCellValue("E{$contador}", $f_docs);
                $excel->getActiveSheet()->setCellValue("F{$contador}", $f_inicio);
                $excel->getActiveSheet()->setCellValue("G{$contador}", $f_final);
                $excel->getActiveSheet()->setCellValue("H{$contador}", $dias);
                $excel->getActiveSheet()->setCellValue("I{$contador}", $res);
            }
                                                              //Creamos objeto para crear el archivo y definimos un nombre de archivo
            $writer   = new Xlsx($excel);                     // instantiate Xlsx
            $filename = 'Reporte_SLAIngles';                  // set filename for excel file to be exported
                                                              //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
        }
        /*else{
							$contador = 2;
							$this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
					}*/
    }
    /*----------------------------------------*/
    /*  Listado Doping
    /*----------------------------------------*/
    public function listado_doping_index()
    {
        $datos['clientes']  = $this->funciones_model->getClientesActivos();
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios']  = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/listado_doping', $datos)
            ->view('adminpanel/footer');
    }

    public function reporteListadoDoping_Excel()
    {
        $datos    = $this->uri->segment(3);
        $dato     = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin    = $dato[1];
        $cliente  = $dato[2];
        $res      = $dato[3];

        if ($res == '') {
            $data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
        } else {
            $data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
        }
        if ($data['datos']) {
            //Se crea objeto de la clase.
            $excel = new Spreadsheet();
            //Contador de filas
            $contador = 1;
            //Le aplicamos ancho las columnas.
            // Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
            //Le aplicamos ancho las columnas.
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(80);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

            //Le aplicamos negrita a los títulos de la cabecera.
            $excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);

            //Definimos los títulos de la cabecera.
            $excel->getActiveSheet()->setCellValue("A{$contador}", 'EMPRESA');
            $excel->getActiveSheet()->setCellValue("B{$contador}", 'CANDIDATO');
            $excel->getActiveSheet()->setCellValue("C{$contador}", 'FECHA ALTA');
            $excel->getActiveSheet()->setCellValue("D{$contador}", 'EXAMEN');
            $excel->getActiveSheet()->setCellValue("E{$contador}", 'PARÁMETROS');
            $excel->getActiveSheet()->setCellValue("F{$contador}", 'FECHA DOPING');
            $excel->getActiveSheet()->setCellValue("G{$contador}", 'RESULTADO');
            $excel->getActiveSheet()->setCellValue("H{$contador}", 'FECHA RESULTADO');

            //Definimos la data del cuerpo.
            foreach ($data['datos'] as $row) {
                $f_alta = ($row->fecha_alta != null) ? fecha_sinhora_espanol_bd($row->fecha_alta) : '-';
                if ($row->tipo_antidoping == 1) {
                    $f_doping = ($row->fecha_doping != null) ? fecha_sinhora_espanol_bd($row->fecha_doping) : 'PENDIENTE';
                    $f_res    = ($row->fecha_resultado != null) ? fecha_sinhora_espanol_bd($row->fecha_resultado) : 'PENDIENTE';
                    $examen   = ($row->examen != null) ? $row->examen : '-';
                    $conjunto = ($row->conjunto != null) ? $row->conjunto : '-';
                    if ($row->resultado != null) {
                        if ($row->resultado != -1) {
                            $resultado = ($row->resultado == 1) ? 'POSITIVO' : 'NEGATIVO';
                        } else {
                            $resultado = 'PENDIENTE';
                        }
                    } else {
                        $resultado = 'PENDIENTE';
                    }
                } else {
                    $f_doping  = 'N/A';
                    $f_res     = 'N/A';
                    $resultado = 'N/A';
                    $examen    = 'N/A';
                    $conjunto  = 'N/A';
                }
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                //Informacion de las filas de la consulta.
                $excel->getActiveSheet()->setCellValue("A{$contador}", $row->cliente);
                $excel->getActiveSheet()->setCellValue("B{$contador}", $row->candidato);
                $excel->getActiveSheet()->setCellValue("C{$contador}", $f_alta);
                $excel->getActiveSheet()->setCellValue("D{$contador}", $examen);
                $excel->getActiveSheet()->setCellValue("E{$contador}", $conjunto);
                $excel->getActiveSheet()->setCellValue("F{$contador}", $f_doping);
                $excel->getActiveSheet()->setCellValue("G{$contador}", $resultado);
                $excel->getActiveSheet()->setCellValue("H{$contador}", $f_res);
            }
                                                              //Creamos objeto para crear el archivo y definimos un nombre de archivo
            $writer   = new Xlsx($excel);                     // instantiate Xlsx
            $filename = 'Reporte_ListadoDoping';              // set filename for excel file to be exported
                                                              //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output'); // download file
        }
    }
    /*----------------------------------------*/
    /*  Listado Clientes
    /*----------------------------------------*/
    public function listado_clientes_index()
    {
        $datos['clientes']  = $this->cat_cliente_model->getC();
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios']  = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/listado_clientes', $datos)
            ->view('adminpanel/footer');
    }
    public function reporteListadoClientes()
    {
        // ===== Validaciones =====
        $this->form_validation->set_rules(
            'cliente',
            $this->lang->line('reportes_val_cliente'),
            'required|trim'
        );

        $this->form_validation->set_message(
            'required',
            $this->lang->line('reportes_val_required')
        );
        $this->form_validation->set_message(
            'numeric',
            $this->lang->line('reportes_val_numeric')
        );

        $msj = [];

        if ($this->form_validation->run() == false) {

            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];

        } else {

            $cliente = $this->input->post('cliente');

            $data['datos'] = $this->reporte_model
                ->reporteListadoDopingClientes($cliente);

            if ($data['datos']) {

                // ===== Botón exportar =====
                $salida = '<div style="text-align:center;margin-bottom:50px;">';
                $salida .= '<a class="btn btn-success" href="'
                . base_url()
                    . 'Reporte/reporteListadoClientes_Excel/'
                    . $cliente
                    . '" target="_blank">';
                $salida .= '<i class="fas fa-file-excel"></i> '
                . $this->lang->line('reportes_btn_export_excel');
                $salida .= '</a></div>';

                // ===== Tabla =====
                $salida .= '<table style="border:0;border-collapse:collapse;width:100%;padding:5px;">';
                $salida .= '<tr>';
                $salida .= '<th>' . $this->lang->line('reportes_th_empresa') . '</th>';
                $salida .= '<th width="20%">' . $this->lang->line('reportes_th_razon_social') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_ingles') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_clave') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_fecha_alta') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_subcliente') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_clave') . '</th>';
                $salida .= '</tr>';

                foreach ($data['datos'] as $row) {

                    $f_alta = ($row->creacion != null)
                        ? fecha_sinhora_espanol_bd($row->creacion)
                        : '-';

                    $ingles = ($row->ingles == 1)
                        ? $this->lang->line('reportes_si')
                        : $this->lang->line('reportes_no');

                    $razon_social = (! empty($row->razon_social))
                        ? $row->razon_social
                        : $this->lang->line('reportes_sin_registro');

                    $subcliente = ($row->subcliente == null)
                        ? $this->lang->line('reportes_sin_registro')
                        : $row->subcliente;

                    $claveSubcliente = ($row->subcliente == null)
                        ? $this->lang->line('reportes_sin_registro')
                        : $row->claveSubcliente;

                    $salida .= '<tr>';
                    $salida .= '<td>' . $row->nombre . '</td>';
                    $salida .= '<td>' . $razon_social . '</td>';
                    $salida .= '<td>' . $ingles . '</td>';
                    $salida .= '<td>' . $row->clave . '</td>';
                    $salida .= '<td>' . $f_alta . '</td>';
                    $salida .= '<td>' . $subcliente . '</td>';
                    $salida .= '<td>' . $claveSubcliente . '</td>';
                    $salida .= '</tr>';
                }

                $salida .= '</table>';

            } else {

                $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">'
                . $this->lang->line('reportes_sin_resultados')
                    . '</p>';
            }

            $msj = [
                'codigo' => 1,
                'msg'    => $salida,
            ];
        }

        echo json_encode($msj);
    }

    public function reporteListadoClientes_Excel()
    {
        $datos   = $this->uri->segment(3);
        $dato    = explode('_', $datos);
        $cliente = $dato[0];

        $data['datos'] = $this->reporte_model
            ->reporteListadoDopingClientes($cliente);

        if ($data['datos']) {

            // === Crear Excel ===
            $excel    = new Spreadsheet();
            $contador = 1;

            // === Ancho de columnas ===
            $sheet = $excel->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(80);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(80);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(25);

            // === Cabecera en negritas ===
            foreach (range('A', 'G') as $col) {
                $sheet->getStyle("{$col}{$contador}")
                    ->getFont()
                    ->setBold(true);
            }

            // === Títulos (idioma) ===
            $sheet->setCellValue("A{$contador}", strtoupper($this->lang->line('reportes_th_empresa')));
            $sheet->setCellValue("B{$contador}", strtoupper($this->lang->line('reportes_th_razon_social')));
            $sheet->setCellValue("C{$contador}", strtoupper($this->lang->line('reportes_th_ingles')));
            $sheet->setCellValue("D{$contador}", strtoupper($this->lang->line('reportes_th_clave')));
            $sheet->setCellValue("E{$contador}", strtoupper($this->lang->line('reportes_th_fecha_alta')));
            $sheet->setCellValue("F{$contador}", strtoupper($this->lang->line('reportes_th_subcliente')));
            $sheet->setCellValue("G{$contador}", strtoupper($this->lang->line('reportes_th_clave')));

            // === Cuerpo ===
            foreach ($data['datos'] as $row) {

                $f_alta = ($row->creacion != null)
                    ? fecha_sinhora_espanol_bd($row->creacion)
                    : '-';

                $ingles = ($row->ingles == 1)
                    ? $this->lang->line('reportes_si')
                    : $this->lang->line('reportes_no');

                $razon_social = (! empty($row->razon_social))
                    ? $row->razon_social
                    : $this->lang->line('reportes_sin_registro');

                $subcliente = ($row->subcliente == null)
                    ? $this->lang->line('reportes_sin_registro')
                    : $row->subcliente;

                $claveSubcliente = ($row->subcliente == null)
                    ? $this->lang->line('reportes_sin_registro')
                    : $row->claveSubcliente;

                $contador++;

                $sheet->setCellValue("A{$contador}", $row->nombre);
                $sheet->setCellValue("B{$contador}", $razon_social);
                $sheet->setCellValue("C{$contador}", $ingles);
                $sheet->setCellValue("D{$contador}", $row->clave);
                $sheet->setCellValue("E{$contador}", $f_alta);
                $sheet->setCellValue("F{$contador}", $subcliente);
                $sheet->setCellValue("G{$contador}", $claveSubcliente);
            }

            // === Exportar ===
            $writer   = new Xlsx($excel);
            $filename = 'Reporte_ListadoClientes';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }

    /*----------------------------------------*/
    /*  Proceso de Reclutamiento
    /*----------------------------------------*/
    public function proceso_reclutamiento_index()
    {
        $datos['usuarios']  = $this->usuario_model->getTipoUsuarios([4, 11]);
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/proceso_reclutamiento', $datos)
            ->view('adminpanel/footer');
    }

    public function reporte_empleados_index()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));

        $datos['sucursales'] = $this->empleados_model->getSucursales($data['permisos']);
        $datos['puestos']    = $this->empleados_model->getPuestos($datos['sucursales']);

        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/reportes_empleados', $datos)
            ->view('adminpanel/footer');
    }

    public function getPuestosYDepartamentos()
    {
        $id = $this->input->post('sucursal_id');

        $datos = $this->empleados_model->getPuestosByCliente($id);

        // Inicializamos arrays únicos
        $puestos       = [];
        $departamentos = [];

        foreach ($datos as $item) {
            // Agregar puestos únicos
            if (! in_array($item->puesto, array_column($puestos, 'puesto'))) {
                $puestos[] = [

                    'nombre' => $item->puesto,
                ];
            }

            // Agregar departamentos únicos
            if (! in_array($item->departamento, array_column($departamentos, 'departamentos'))) {
                $departamentos[] = [

                    'nombre' => $item->departamento,
                ];
            }
        }

        $response = [
            'puestos'       => $puestos,
            'departamentos' => $departamentos,
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function reporte_exempleados()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));

        $datos['sucursales'] = $this->empleados_model->getSucursales($data['permisos']);
        $datos['puestos']    = $this->empleados_model->getPuestos($datos['sucursales']);

        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reportes/reportes_exempleados', $datos)
            ->view('adminpanel/footer');
    }
    public function exportar_excel()
    {
        $portal = $this->session->userdata('idPortal');
        $this->load->database();

        $sucursal     = $this->input->post('sucursal');
        $campos       = $this->input->post('campos') ?? [];
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin    = $this->input->post('fecha_fin');
        $puesto       = $this->input->post('puesto');
        $departamento = $this->input->post('departamento');

        $this->db->select("
        empleados.id,
        empleados.id_empleado,
        empleados.id_domicilio_empleado,
        CONCAT_WS(' ', empleados.nombre, empleados.paterno, empleados.materno) AS Nombre_Colaborador,
        empleados.telefono AS Telefono,
        empleados.correo AS Correo,
        empleados.departamento AS Area_Departamento,
        empleados.puesto AS Puesto,
        empleados.rfc AS RFC,
        empleados.nss AS NSS,
        empleados.curp AS CURP,
        empleados.fecha_nacimiento AS Fecha_Nacimiento,
        empleados.creacion  AS Fecha_Ingreso
        ");
        $this->db->from('empleados');
        $this->db->where('empleados.status', 1);
        $this->db->where('empleados.eliminado', 0);

        if ($sucursal) {
            $this->db->where('empleados.id_cliente', $sucursal);
        } else {
            $this->db->where('empleados.id_portal', $portal);
        }

        if ($fecha_inicio && $fecha_fin) {
            $this->db->where('empleados.creacion >=', $fecha_inicio);
            $this->db->where('empleados.creacion <=', $fecha_fin);
        }

        if ($puesto) {
            $this->db->where('empleados.puesto', $puesto);
        }

        if ($departamento) {
            $this->db->where('empleados.departamento', $departamento);
        }

        $query     = $this->db->get();
        $empleados = $query->result_array();

        foreach ($empleados as &$empleado) {
            $id = $empleado['id'];

            // Campos extra
            $campos_extra = $this->db
                ->select('nombre, valor')
                ->from('empleado_campos_extra')
                ->where('id_empleado', $id)
                ->get()
                ->result_array();
            foreach ($campos_extra as $campo) {
                $empleado[$campo['nombre']] = $campo['valor'];
            }
            if (in_array('domicilios_empleados', $campos) && ! empty($empleado['id_domicilio_empleado'])) {
                $domicilio = $this->db
                    ->select('pais, estado, ciudad, calle, colonia, cp, num_int, num_ext')
                    ->from('domicilios_empleados')
                    ->where('id', $empleado['id_domicilio_empleado'])
                    ->get()
                    ->row_array();

                $partes = [];
                foreach (['pais', 'estado', 'ciudad', 'colonia', 'calle', 'num_int', 'num_ext'] as $campo) {
                    if (! empty($domicilio[$campo])) {
                        $texto = strtoupper($campo) . ': ' . $domicilio[$campo];

                        // Insertar salto de línea después de ciudad
                        if ($campo === 'colonia') {
                            $texto .= "\n"; // o "<br>" si es HTML
                        }

                        $partes[] = $texto;
                    }
                }
                $empleado['Domicilio'] = implode(', ', $partes);
            }
            // Información médica
            if (in_array('medical_info', $campos)) {
                $med = $this->db->from('medical_info')->where('id_empleado', $id)->get()->row_array();
                if ($med) {
                    foreach ($med as $k => $v) {
                        if (! in_array($k, ['id', 'creacion', 'edicion', 'id_empleado'])) {
                            $empleado["Med_" . ucfirst($k)] = $v;
                        }
                    }
                }
            }

            // Información laboral
            if (in_array('laborales_empleado', $campos)) {
                $lab = $this->db->from('laborales_empleado')->where('id_empleado', $id)->get()->row_array();
                if ($lab) {
                    foreach ($lab as $k => $v) {
                        if (! in_array($k, ['id', 'id_empleado'])) {
                            $empleado["Lab_" . ucfirst($k)] = $v;
                        }
                    }
                }
            }

            // Documentos
            if (in_array('documents_empleado', $campos)) {
                $docs = $this->db
                    ->select('documents_empleado.name, description, expiry_date, status, document_options.name AS tipo_documento')
                    ->from('documents_empleado')
                    ->join('document_options', 'document_options.id = documents_empleado.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Documentos'] = '';
                if (! empty($docs)) {
                    foreach ($docs as $doc) {
                        $empleado['Documentos'] .= "Nombre: {$doc['tipo_documento']}\nDescripción: {$doc['description']}\nExpira: {$doc['expiry_date']}\n\n";
                    }
                }
            }

            // Exámenes
            if (in_array('exams_empleados', $campos)) {
                $exams = $this->db
                    ->select('exams_empleados.name, expiry_date, description, options.name AS tipo_examen')
                    ->from('exams_empleados')
                    ->join('exams_options AS options', 'options.id = exams_empleados.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Examenes'] = '';
                if (! empty($exams)) {
                    foreach ($exams as $exam) {
                        $empleado['Examenes'] .= "Tipo: {$exam['tipo_examen']}\nDescripción: {$exam['description']}\nExpira: {$exam['expiry_date']}\n\n";
                    }
                }
            }

            // Cursos
            if (in_array('cursos_empleados', $campos)) {
                $cursos = $this->db
                    ->select('C.name, C.expiry_date, C.description, C.id_opcion, options.name AS oname')
                    ->from('cursos_empleados AS C')
                    ->join('cursos_options AS options', 'options.id = C.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Cursos'] = '';
                if (! empty($cursos)) {
                    foreach ($cursos as $curso) {
                        $nombre = empty($curso['id_opcion']) ? $curso['name'] : $curso['oname'];
                        $empleado['Cursos'] .= "Nombre: {$nombre}\nDescripción: {$curso['description']}\nExpira: {$curso['expiry_date']}\n\n";
                    }
                }
            }

            // Domicilio

            unset($empleado['id_domicilio_empleado']);
        }

        // Generar Excel una sola vez
        $finalData = $empleados;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        if (! empty($finalData)) {
            $headers = array_keys($finalData[0]);

            // Eliminar columnas vacías
            $columnas_vacias = [];
            foreach ($headers as $header) {
                $vacia = true;
                foreach ($finalData as $empleado) {
                    if (! empty($empleado[$header])) {
                        $vacia = false;
                        break;
                    }
                }
                if ($vacia) {
                    $columnas_vacias[] = $header;
                }
            }

            foreach ($finalData as &$empleado) {
                foreach ($columnas_vacias as $col) {
                    unset($empleado[$col]);
                }
            }

            $headers        = array_keys($finalData[0]);
            $column_aliases = [];
            foreach ($headers as $header) {
                $column_aliases[$header] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $header)));
            }

            $sheet->fromArray(array_values($column_aliases), null, 'A1');

            $colCount    = count($headers);
            $headerStyle = [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'wrapText' => true],
            ];

            for ($col = 0; $col < $colCount; $col++) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                $sheet->getStyle($colLetter . '1')->applyFromArray($headerStyle);
                $sheet->getColumnDimension($colLetter)->setAutoSize(true);
            }

            $rowIndex = 2;
            foreach ($finalData as $row) {
                $rowData = [];
                foreach ($headers as $header) {
                    $valor     = isset($row[$header]) && trim($row[$header]) !== '' ? $row[$header] : '-';
                    $rowData[] = $valor;
                }
                $sheet->fromArray($rowData, null, 'A' . $rowIndex);
                for ($col = 0; $col < count($headers); $col++) {
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                    $sheet->getStyle($colLetter . $rowIndex)->getAlignment()->setWrapText(true);
                }
                $rowIndex++;
            }
        }

        $filename = 'reporte_empleados_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function exportar_excel_ex()
    {
        $portal = $this->session->userdata('idPortal');
        $this->load->database();

        $sucursal     = $this->input->post('sucursal');
        $campos       = $this->input->post('campos') ?? [];
        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_fin    = $this->input->post('fecha_fin');
        $puesto       = $this->input->post('puesto');
        $departamento = $this->input->post('departamento');

        $this->db->select("
        empleados.id,
        empleados.id_empleado,
        empleados.id_domicilio_empleado,
        CONCAT_WS(' ', empleados.nombre, empleados.paterno, empleados.materno) AS Nombre_Colaborador,
        empleados.telefono AS Telefono,
        empleados.correo AS Correo,
        empleados.departamento AS Area_Departamento,
        empleados.puesto AS Puesto,
        empleados.rfc AS RFC,
        empleados.nss AS NSS,
        empleados.curp AS CURP,
        empleados.fecha_nacimiento AS Fecha_Nacimiento,
        empleados.creacion  AS Fecha_Ingreso,
        m.creacion AS Fecha_Salida
        ", false);

        $this->db->from('empleados');
        // 👇 Subconsulta como string literal, con alias m
        $subquery = "(SELECT id_empleado, MIN(creacion) AS creacion
              FROM comentarios_former_empleado
              WHERE creacion IS NOT NULL
              GROUP BY id_empleado) m";

        // 👇 join sin backticks automáticos
        $this->db->join($subquery, 'm.id_empleado = empleados.id', 'left', false);
        $this->db->where('empleados.status', 2);
        $this->db->where('empleados.eliminado', 0);
        if ($sucursal) {
            $this->db->where('empleados.id_cliente', $sucursal);
        } else {
            $this->db->where('empleados.id_portal', $portal);
        }

        if ($fecha_inicio && $fecha_fin) {
            $this->db->where('empleados.creacion >=', $fecha_inicio);
            $this->db->where('empleados.creacion <=', $fecha_fin);
        }

        if ($puesto) {
            $this->db->where('empleados.puesto', $puesto);
        }

        if ($departamento) {
            $this->db->where('empleados.departamento', $departamento);
        }

        $query     = $this->db->get();
        $empleados = $query->result_array();

        foreach ($empleados as &$empleado) {
            $id = $empleado['id'];

            // Campos extra
            $campos_extra = $this->db
                ->select('nombre, valor')
                ->from('empleado_campos_extra')
                ->where('id_empleado', $id)
                ->get()
                ->result_array();
            foreach ($campos_extra as $campo) {
                $empleado[$campo['nombre']] = $campo['valor'];
            }
            if (in_array('domicilios_empleados', $campos) && ! empty($empleado['id_domicilio_empleado'])) {
                $domicilio = $this->db
                    ->select('pais, estado, ciudad, calle, colonia, cp, num_int, num_ext')
                    ->from('domicilios_empleados')
                    ->where('id', $empleado['id_domicilio_empleado'])
                    ->get()
                    ->row_array();

                $partes = [];
                foreach (['pais', 'estado', 'ciudad', 'colonia', 'calle', 'num_int', 'num_ext'] as $campo) {
                    if (! empty($domicilio[$campo])) {
                        $texto = strtoupper($campo) . ': ' . $domicilio[$campo];

                        // Insertar salto de línea después de ciudad
                        if ($campo === 'colonia') {
                            $texto .= "\n"; // o "<br>" si es HTML
                        }

                        $partes[] = $texto;
                    }
                }
                $empleado['Domicilio'] = implode(', ', $partes);
            }
            // Información médica
            if (in_array('medical_info', $campos)) {
                $med = $this->db->from('medical_info')->where('id_empleado', $id)->get()->row_array();
                if ($med) {
                    foreach ($med as $k => $v) {
                        if (! in_array($k, ['id', 'creacion', 'edicion', 'id_empleado'])) {
                            $empleado["Med_" . ucfirst($k)] = $v;
                        }
                    }
                }
            }

            // Información laboral
            if (in_array('laborales_empleado', $campos)) {
                $lab = $this->db->from('laborales_empleado')->where('id_empleado', $id)->get()->row_array();
                if ($lab) {
                    foreach ($lab as $k => $v) {
                        if (! in_array($k, ['id', 'id_empleado'])) {
                            $empleado["Lab_" . ucfirst($k)] = $v;
                        }
                    }
                }
            }

            // Documentos
            if (in_array('documents_empleado', $campos)) {
                $docs = $this->db
                    ->select('documents_empleado.name, description, expiry_date, status, document_options.name AS tipo_documento')
                    ->from('documents_empleado')
                    ->join('document_options', 'document_options.id = documents_empleado.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Documentos'] = '';
                if (! empty($docs)) {
                    foreach ($docs as $doc) {
                        $empleado['Documentos'] .= "Nombre: {$doc['tipo_documento']}\nDescripción: {$doc['description']}\nExpira: {$doc['expiry_date']}\n\n";
                    }
                }
            }

            // Exámenes
            if (in_array('exams_empleados', $campos)) {
                $exams = $this->db
                    ->select('exams_empleados.name, expiry_date, description, options.name AS tipo_examen')
                    ->from('exams_empleados')
                    ->join('exams_options AS options', 'options.id = exams_empleados.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Examenes'] = '';
                if (! empty($exams)) {
                    foreach ($exams as $exam) {
                        $empleado['Examenes'] .= "Tipo: {$exam['tipo_examen']}\nDescripción: {$exam['description']}\nExpira: {$exam['expiry_date']}\n\n";
                    }
                }
            }

            // Cursos
            if (in_array('cursos_empleados', $campos)) {
                $cursos = $this->db
                    ->select('C.name, C.expiry_date, C.description, C.id_opcion, options.name AS oname')
                    ->from('cursos_empleados AS C')
                    ->join('cursos_options AS options', 'options.id = C.id_opcion', 'left')
                    ->where('employee_id', $id)
                    ->get()
                    ->result_array();

                $empleado['Cursos'] = '';
                if (! empty($cursos)) {
                    foreach ($cursos as $curso) {
                        $nombre = empty($curso['id_opcion']) ? $curso['name'] : $curso['oname'];
                        $empleado['Cursos'] .= "Nombre: {$nombre}\nDescripción: {$curso['description']}\nExpira: {$curso['expiry_date']}\n\n";
                    }
                }
            }

            // Domicilio

            unset($empleado['id_domicilio_empleado']);
        }

        // Generar Excel una sola vez
        $finalData = $empleados;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        if (! empty($finalData)) {
            $headers = array_keys($finalData[0]);

            // Eliminar columnas vacías
            $columnas_vacias = [];
            foreach ($headers as $header) {
                $vacia = true;
                foreach ($finalData as $empleado) {
                    if (! empty($empleado[$header])) {
                        $vacia = false;
                        break;
                    }
                }
                if ($vacia) {
                    $columnas_vacias[] = $header;
                }
            }

            foreach ($finalData as &$empleado) {
                foreach ($columnas_vacias as $col) {
                    unset($empleado[$col]);
                }
            }

            $headers        = array_keys($finalData[0]);
            $column_aliases = [];
            foreach ($headers as $header) {
                $column_aliases[$header] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $header)));
            }

            $sheet->fromArray(array_values($column_aliases), null, 'A1');

            $colCount    = count($headers);
            $headerStyle = [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'wrapText' => true],
            ];

            for ($col = 0; $col < $colCount; $col++) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                $sheet->getStyle($colLetter . '1')->applyFromArray($headerStyle);
                $sheet->getColumnDimension($colLetter)->setAutoSize(true);
            }

            $rowIndex = 2;
            foreach ($finalData as $row) {
                $rowData = [];
                foreach ($headers as $header) {
                    $valor     = isset($row[$header]) && trim($row[$header]) !== '' ? $row[$header] : '-';
                    $rowData[] = $valor;
                }
                $sheet->fromArray($rowData, null, 'A' . $rowIndex);
                for ($col = 0; $col < count($headers); $col++) {
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                    $sheet->getStyle($colLetter . $rowIndex)->getAlignment()->setWrapText(true);
                }
                $rowIndex++;
            }
        }

        $filename = 'reporte_empleados_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function reporteProcesoReclutamiento()
    {
        // ===== Validaciones =====
        $this->form_validation->set_rules(
            'fecha_inicio',
            $this->lang->line('reportes_fecha_inicio'),
            'required|trim'
        );
        $this->form_validation->set_rules(
            'fecha_fin',
            $this->lang->line('reportes_fecha_fin'),
            'required|trim'
        );
        $this->form_validation->set_rules(
            'usuario',
            $this->lang->line('reportes_reclutador'),
            'required|trim'
        );

        $this->form_validation->set_message(
            'required',
            $this->lang->line('reportes_val_required')
        );
        $this->form_validation->set_message(
            'numeric',
            $this->lang->line('reportes_val_numeric')
        );

        $msj = [];

        if ($this->form_validation->run() == false) {

            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];

        } else {

            $f_inicio = $this->input->post('fecha_inicio');
            $f_fin    = $this->input->post('fecha_fin');
            $usuario  = $this->input->post('usuario');

            $data['datos'] = $this->reporte_model
                ->reporteProcesoReclutamiento($f_inicio, $f_fin, $usuario);

            if ($data['datos']) {

                // ===== Botón Excel =====
                $salida = '<div style="text-align:center;margin-bottom:50px;">';
                $salida .= '<a class="btn btn-success" href="'
                . base_url()
                    . 'Reporte/reporteProcesoReclutamiento_Excel/'
                    . $f_inicio . '_' . $f_fin . '_' . $usuario
                    . '" target="_blank">';
                $salida .= '<i class="fas fa-file-excel"></i> '
                . $this->lang->line('reportes_btn_export_excel');
                $salida .= '</a></div>';

                // ===== Tabla =====
                $salida .= '<table style="border:0;border-collapse:collapse;width:100%;padding:5px;">';
                $salida .= '<tr>';
                $salida .= '<th>' . $this->lang->line('reportes_th_reclutador') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_fecha_registro') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_aspirante') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_telefono') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_domicilio') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_medio_contacto') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_cliente') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_puesto') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_sueldo') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_fecha_requisicion') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_fecha_ingreso') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_garantia') . '</th>';
                $salida .= '<th>' . $this->lang->line('reportes_th_pago') . '</th>';
                $salida .= '</tr>';

                foreach ($data['datos'] as $row) {

                    $f_registro = ($row->creacion)
                        ? fecha_sinhora_espanol_bd($row->creacion)
                        : '-';

                    $usuarioTxt = ($row->usuario)
                        ? $row->usuario
                        : $this->lang->line('reportes_sin_asignar');

                    $comercial = ($row->nombre_comercial)
                        ? ' - ' . $row->nombre_comercial
                        : '';

                    $cliente = $row->cliente . $comercial;

                    $f_requisicion = ($row->fechaRequisicion)
                        ? fecha_sinhora_espanol_bd($row->fechaRequisicion)
                        : '-';

                    $sueldo = ($row->sueldo_acordado)
                        ? '$' . $row->sueldo_acordado
                        : '-';

                    $f_ingreso = ($row->fecha_ingreso)
                        ? fecha_sinhora_espanol_bd($row->fecha_ingreso)
                        : '-';

                    $garantia = $row->garantia ?: '-';
                    $pago     = $row->pago ?: '-';

                    $salida .= '<tr>';
                    $salida .= '<td>' . $usuarioTxt . '</td>';
                    $salida .= '<td>' . $f_registro . '</td>';
                    $salida .= '<td>' . $row->aspirante . '</td>';
                    $salida .= '<td>' . $row->telefono . '</td>';
                    $salida .= '<td>' . $row->domicilio . '</td>';
                    $salida .= '<td>' . $row->medio_contacto . '</td>';
                    $salida .= '<td>' . $cliente . '</td>';
                    $salida .= '<td>' . $row->puesto . '</td>';
                    $salida .= '<td>' . $sueldo . '</td>';
                    $salida .= '<td>' . $f_requisicion . '</td>';
                    $salida .= '<td>' . $f_ingreso . '</td>';
                    $salida .= '<td>' . $garantia . '</td>';
                    $salida .= '<td>' . $pago . '</td>';
                    $salida .= '</tr>';
                }

                $salida .= '</table>';

            } else {

                $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">'
                . $this->lang->line('reportes_sin_resultados')
                    . '</p>';
            }

            $msj = [
                'codigo' => 1,
                'msg'    => $salida,
            ];
        }

        echo json_encode($msj);
    }

    public function reporteProcesoReclutamiento_Excel()
    {
        $datos    = $this->uri->segment(3);
        $dato     = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin    = $dato[1];
        $usuario  = $dato[2];

        $data['datos'] = $this->reporte_model
            ->reporteProcesoReclutamiento($f_inicio, $f_fin, $usuario);

        if ($data['datos']) {

            $excel    = new Spreadsheet();
            $sheet    = $excel->getActiveSheet();
            $contador = 1;

            // === Anchos ===
            $widths = [
                'A' => 25, 'B' => 15, 'C' => 35, 'D' => 15, 'E' => 25, 'F' => 20,
                'G' => 35, 'H' => 35, 'I' => 15, 'J' => 15, 'K' => 15, 'L' => 30, 'M' => 20,
            ];
            foreach ($widths as $c => $w) {
                $sheet->getColumnDimension($c)->setWidth($w);
            }

            // === Negritas ===
            foreach (range('A', 'M') as $col) {
                $sheet->getStyle("{$col}{$contador}")
                    ->getFont()->setBold(true);
            }

            // === Cabecera ===
            $headers = [
                'A' => 'reportes_th_reclutador',
                'B' => 'reportes_th_fecha_registro',
                'C' => 'reportes_th_aspirante',
                'D' => 'reportes_th_telefono',
                'E' => 'reportes_th_domicilio',
                'F' => 'reportes_th_medio_contacto',
                'G' => 'reportes_th_cliente',
                'H' => 'reportes_th_puesto',
                'I' => 'reportes_th_sueldo',
                'J' => 'reportes_th_fecha_requisicion',
                'K' => 'reportes_th_fecha_ingreso',
                'L' => 'reportes_th_garantia',
                'M' => 'reportes_th_pago',
            ];

            foreach ($headers as $col => $key) {
                $sheet->setCellValue(
                    "{$col}{$contador}",
                    strtoupper($this->lang->line($key))
                );
            }

            // === Datos ===
            foreach ($data['datos'] as $row) {

                $contador++;

                $sheet->setCellValue("A{$contador}", $row->usuario ?: $this->lang->line('reportes_sin_asignar'));
                $sheet->setCellValue("B{$contador}", $row->creacion ? fecha_sinhora_espanol_bd($row->creacion) : '-');
                $sheet->setCellValue("C{$contador}", $row->aspirante);
                $sheet->setCellValue("D{$contador}", $row->telefono);
                $sheet->setCellValue("E{$contador}", $row->domicilio);
                $sheet->setCellValue("F{$contador}", $row->medio_contacto);
                $sheet->setCellValue("G{$contador}", $row->cliente);
                $sheet->setCellValue("H{$contador}", $row->puesto);
                $sheet->setCellValue("I{$contador}", $row->sueldo_acordado ? '$' . $row->sueldo_acordado : '-');
                $sheet->setCellValue("J{$contador}", $row->fechaRequisicion ? fecha_sinhora_espanol_bd($row->fechaRequisicion) : '-');
                $sheet->setCellValue("K{$contador}", $row->fecha_ingreso ? fecha_sinhora_espanol_bd($row->fecha_ingreso) : '-');
                $sheet->setCellValue("L{$contador}", $row->garantia ?: '-');
                $sheet->setCellValue("M{$contador}", $row->pago ?: '-');
            }

            $writer   = new Xlsx($excel);
            $filename = 'Reporte_Procesos_Reclutamiento';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }

}

/*  public function reporteListadoDoping()
    {
        $this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
        $this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $f_inicio = fecha_espanol_bd($this->input->post('fi'));
            $f_fin    = fecha_espanol_bd($this->input->post('ff'));
            $cliente  = $this->input->post('cliente');
            $res      = $this->input->post('resultado');

            $diaInicio = new DateTime($f_inicio);
            $diaFinal  = new DateTime($f_fin);
            if ($diaInicio > $diaFinal) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Fechas a filtrar no son válidas',
                ];
            } else {
                if ($res == '') {
                    $data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
                } else {
                    $data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
                }
                if ($data['datos']) {
                    $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="' . base_url() . 'Reporte/reporteListadoDoping_Excel/' . $f_inicio . '_' . $f_fin . '_' . $cliente . '_' . $res . '" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
                    $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
                    $salida .= '<tr>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Empresa</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Candidato</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha Alta</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Examen</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Conjunto</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha Doping</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Resultado</th>';
                    $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha de Resultado</th>';
                    $salida .= '</tr>';
                    foreach ($data['datos'] as $row) {
                        $f_alta = ($row->fecha_alta != null) ? fecha_sinhora_espanol_bd($row->fecha_alta) : '-';
                        if ($row->tipo_antidoping == 1) {
                            $f_doping = ($row->fecha_doping != null) ? fecha_sinhora_espanol_bd($row->fecha_doping) : 'PENDIENTE';
                            $f_res    = ($row->fecha_resultado != null) ? fecha_sinhora_espanol_bd($row->fecha_resultado) : 'PENDIENTE';
                            $examen   = ($row->examen != null) ? $row->examen : '-';
                            $conjunto = ($row->conjunto != null) ? $row->conjunto : '-';
                            if ($row->resultado != null) {
                                if ($row->resultado != -1) {
                                    $resultado = ($row->resultado == 1) ? 'POSITIVO' : 'NEGATIVO';
                                } else {
                                    $resultado = 'PENDIENTE';
                                }
                            } else {
                                $resultado = 'PENDIENTE';
                            }
                        } else {
                            $f_doping  = 'N/A';
                            $f_res     = 'N/A';
                            $resultado = 'N/A';
                            $examen    = 'N/A';
                            $conjunto  = 'N/A';
                        }
                        //
                        $salida .= "<tr><tbody>";
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->cliente . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $row->candidato . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_alta . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $examen . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $conjunto . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_doping . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $resultado . '</td>';
                        $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">' . $f_res . '</td>';
                        $salida .= "</tbody></tr>";
                    }
                    $salida .= "</table>";
                } else {
                    $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida,
                ];
            }

        }
        echo json_encode($msj);
    } */
