<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reporte extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

	function index(){
		$datos['candidatos'] = $this->doping_model->getCandidatosSinDoping();
		$datos['paquetes'] = $this->doping_model->getPaquetesAntidoping();
		$datos['clientes'] = $this->funciones_model->getClientesActivos();
		$datos['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
		$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
		$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
		foreach($data['submodulos'] as $row) {
			$items[] = $row->id_submodulo;
		}
		$data['submenus'] = $items;
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
		->view('reportes/reportes_index',$datos)
		->view('adminpanel/footer');
	}
    function getSubclientes(){
        $id_cliente = $_POST['id_cliente'];
        $data['subclientes'] = $this->reporte_model->getSubclientes($id_cliente);
        $salida = "<option value=''>Selecciona Subcliente</option>";
        if($data['subclientes']){
            $salida .= "<option value='0'>TODOS</option>";
            foreach ($data['subclientes'] as $row){
                $salida .= "<option value='".$row->id."'>".$row->nombre."</option>";
            } 
            echo $salida;
        }
        else{
            $salida .= "<option value=''>N/A</option>";
            echo $salida;
        }
    }
    function getProyectos(){
        $id_cliente = $_POST['id_cliente'];
        $data['proyectos'] = $this->doping_model->getProyectos($id_cliente);
        $salida = "<option value=''>Selecciona Proyecto</option>";
        if($data['proyectos']){
            $salida .= "<option value='0'>TODOS</option>";
            foreach ($data['proyectos'] as $row){
                $salida .= "<option value='".$row->id."'>".$row->nombre."</option>";
            } 
            echo $salida;
        }
        else{
            $salida .= "<option value=''>N/A</option>";
            echo $salida;
        }
    }
    function reporteDopingFinalizados(){
        $f_inicio = fecha_espanol_bd($_POST['fi']);
        $f_fin = fecha_espanol_bd($_POST['ff']);
        $cliente = $_POST['cliente'];
        $subcliente = $_POST['subcliente'];
        $proyecto = $_POST['proyecto'];
        $resultado = $_POST['res'];
        $lab = $_POST['lab'];

        $data['datos'] = $this->reporte_model->reporteDopingFinalizados($f_inicio, $f_fin, $cliente, $subcliente, $proyecto, $resultado, $lab);
        //var_dump($data['datos']);
        if($data['datos']){
            $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteDopingFinalizados_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$subcliente.'_'.$proyecto.'_'.$resultado.'_'.$lab.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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
            foreach($data['datos'] as $row){
                $subcliente = ($row->subcliente != "" && $row->subcliente != null)? $row->subcliente:"-";
                $proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
                $f_doping = $this->reporteFecha($row->fecha_doping);
                $f_resultado = ($row->fecha_resultado != "" && $row->fecha_resultado != null)? $this->reporteFecha($row->fecha_resultado):"Sin resultado";
                $res = ($row->resultado == 1)? "Positivo":"Negativo";
                $salida .= "<tr><tbody>";
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_doping.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$subcliente.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$proyecto.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->parametros.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->codigo_prueba.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_resultado.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$res.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->laboratorio.'</td>';
                $salida .= "</tbody></tr>";
            }
            $salida .= "</table>";
        }
        else{
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
        }
        echo $salida;
    }
    function reporteDopingFinalizados_Excel(){
        $datos = $this->uri->segment(3);
        $dato = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin = $dato[1];
        $cliente = $dato[2];
        $subcliente = $dato[3];
        $proyecto = $dato[4];
        $resultado = $dato[5];
        $lab = $dato[6];
        $data['datos'] = $this->reporte_model->reporteDopingFinalizados($f_inicio, $f_fin, $cliente, $subcliente, $proyecto, $resultado, $lab);
        if($data['datos']){
            //Se crea objeto de la clase.
            $excel  = new Spreadsheet();
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
            foreach($data['datos'] as $row){
                $subcliente = ($row->subcliente != "" && $row->subcliente != null)? $row->subcliente:"-";
                $proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
                $f_doping = $this->reporteFecha($row->fecha_doping);
                $f_resultado = ($row->fecha_resultado != "" && $row->fecha_resultado != null)? $this->reporteFecha($row->fecha_resultado):"Sin resultado";
                $res = ($row->resultado == 1)? "Positivo":"Negativo";
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
            $writer = new Xlsx($excel); // instantiate Xlsx
            $filename = 'Reporte1_RegistrosDopingFinalizados'; // set filename for excel file to be exported
            //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');	// download file 
        }
        /*else{
            $contador = 2;
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
        }*/
    }
    function reporteEstudiosFinalizados(){
        $f_inicio = fecha_espanol_bd($_POST['fi']);
        $f_fin = fecha_espanol_bd($_POST['ff']);
        $cliente = $_POST['cliente'];
        $usuario = $_POST['usuario'];

        $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteEstudiosFinalizados_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$usuario.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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

        if($usuario == 0){
            $data['usuarios'] = $this->reporte_model->getUsuarios();
            foreach($data['usuarios'] as $user){
                if($cliente == 0){
                    $data['data'] = $this->reporte_model->getClientes();
                    foreach($data['data'] as $cl){
                        if($cl->id == 1 || $cl->id == 2){
                            $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos1']){
                                foreach($data['datos1'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            }
                            else{
                                $band = 1;
                            }
                        }
                        elseif($cl->id == 3 || $cl->id == 77){
                            $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos2']){
                                foreach($data['datos2'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo_parcial.' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            }
                            else{
                                $band = 1;
                            }
                        }
                        else{
                            $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos3']){
                                foreach($data['datos3'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
                                    $f_final = $this->reporteFecha($row->fecha_final);
                                    $salida .= '<tr>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                    $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                    $salida .= '</tr>';
                                }
                                $band = 0;
                            }
                            else{
                                $band = 1;
                            }
                        }
                        
                    }
                    
                }
                else{
                    if($cliente == 1 || $cliente == 2){
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos1']){
                            foreach($data['datos1'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                $salida .= '</tr>';
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                    elseif($cliente == 3 || $cliente == 77){
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos2']){
                            foreach($data['datos2'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo_parcial.' días</td>';
                                $salida .= '</tr>';
                                
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                    else{
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos3']){
                            foreach($data['datos3'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                $salida .= '</tr>';
                                
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                }
            }
            $salida .= "</tbody>";
            $salida .= "</table>";
        }
        else{
            if($cliente == 0){
                $data['data'] = $this->reporte_model->getClientes();
                foreach($data['data'] as $cl){
                    if($cl->id == 1 || $cl->id == 2){
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos1']){
                            foreach($data['datos1'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                $salida .= '</tr>';
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                    elseif($cl->id == 3 || $cl->id == 77){
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos2']){
                            foreach($data['datos2'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo_parcial.' días</td>';
                                $salida .= '</tr>';
                                
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                    else{
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos3']){
                            foreach($data['datos3'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
                                $f_final = $this->reporteFecha($row->fecha_final);
                                $salida .= '<tr>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                                $salida .= '</tr>';
                                
                            }
                            $band = 0;
                        }
                        else{
                            $band = 1;
                        }
                    }
                }
                $salida .= "</tbody></tr>";
                $salida .= "</table>";
            }
            else{
                if($cliente == 1 || $cliente == 2){
                    $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos1']){
                        foreach($data['datos1'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                            $salida .= '</tr>';
                        }
                        $band = 0;
                    }
                    else{
                        $band = 1;
                    }
                }
                elseif($cliente == 3 || $cliente == 77){
                    $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos2']){
                        foreach($data['datos2'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo_parcial.' días</td>';
                            $salida .= '</tr>';
                            
                        }
                        $band = 0;
                    }
                    else{
                        $band = 1;
                    }
                }
                else{
                    $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos3']){
                        foreach($data['datos3'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
                            $f_final = $this->reporteFecha($row->fecha_final);
                            $salida .= '<tr>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->usuario.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                            $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->tiempo.' días</td>';
                            $salida .= '</tr>';
                            
                        }
                        $band = 0;
                    }
                    else{
                        $band = 1;
                    }
                }
            }
        }

        echo $salida;
    }
    function reporteEstudiosFinalizados_Excel(){
        $datos = $this->uri->segment(3);
        $dato = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin = $dato[1];
        $cliente = $dato[2];
        $usuario = $dato[3];
        $salida = '';
        //Se crea objeto de la clase.
        $excel  = new Spreadsheet();
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
        
        if($usuario == 0){
            $data['usuarios'] = $this->reporte_model->getUsuarios();
            foreach($data['usuarios'] as $user){
                if($cliente == 0){
                    $data['data'] = $this->reporte_model->getClientes();
                    foreach($data['data'] as $cl){
                        if($cl->id == 1 || $cl->id == 2){
                            $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos1']){
                                foreach($data['datos1'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
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
                            }
                            else{
                                $band = 1;
                            }
                        }
                        elseif($cl->id == 3 || $cl->id == 77){
                            $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos2']){
                                foreach($data['datos2'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
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
                            }
                            else{
                                $band = 1;
                            }
                        }
                        else{
                            $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $user->id);
                            if($data['datos3']){
                                foreach($data['datos3'] as $row){
                                    $f_alta = $this->reporteFecha($row->fecha_alta);
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
                            }
                            else{
                                $band = 1;
                            }
                        }
                        
                    }
                    
                }
                else{
                    if($cliente == 1 || $cliente == 2){
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos1']){
                            foreach($data['datos1'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                    elseif($cliente == 3 || $cliente == 77){
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos2']){
                            foreach($data['datos2'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                    else{
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $user->id);
                        if($data['datos3']){
                            foreach($data['datos3'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                }
            }
            $salida .= "</tbody>";
            $salida .= "</table>";
        }
        else{
            if($cliente == 0){
                $data['data'] = $this->reporte_model->getClientes();
                foreach($data['data'] as $cl){
                    if($cl->id == 1 || $cl->id == 2){
                        $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos1']){
                            foreach($data['datos1'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                    elseif($cl->id == 3 || $cl->id == 77){
                        $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos2']){
                            foreach($data['datos2'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                    else{
                        $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cl->id, $usuario);
                        if($data['datos3']){
                            foreach($data['datos3'] as $row){
                                $f_alta = $this->reporteFecha($row->fecha_alta);
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
                        }
                        else{
                            $band = 1;
                        }
                    }
                }
                $salida .= "</tbody></tr>";
                $salida .= "</table>";
            }
            else{
                if($cliente == 1 || $cliente == 2){
                    $data['datos1'] = $this->reporte_model->reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos1']){
                        foreach($data['datos1'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
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
                    }
                    else{
                        $band = 1;
                    }
                }
                elseif($cliente == 3 || $cliente == 77){
                    $data['datos2'] = $this->reporte_model->reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos2']){
                        foreach($data['datos2'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
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
                    }
                    else{
                        $band = 1;
                    }
                }
                else{
                    $data['datos3'] = $this->reporte_model->reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $usuario);
                    if($data['datos3']){
                        foreach($data['datos3'] as $row){
                            $f_alta = $this->reporteFecha($row->fecha_alta);
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
                    }
                    else{
                        $band = 1;
                    }
                }
            }
        }
        //Creamos objeto para crear el archivo y definimos un nombre de archivo
        $writer = new Xlsx($excel); // instantiate Xlsx
        $filename = 'Reporte2_RegistrosESEFinalizados'; // set filename for excel file to be exported
        //Cabeceras
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');	// download file 
    }
    function reporteDopingGeneral(){
        $f_inicio = fecha_espanol_bd($_POST['fi']);
        $f_fin = fecha_espanol_bd($_POST['ff']);
        $cliente = $_POST['cliente'];
        $subcliente = $_POST['subcliente'];
        $proyecto = $_POST['proyecto'];

        $data['datos'] = $this->reporte_model->reporteDopingGeneral($f_inicio, $f_fin, $cliente, $subcliente, $proyecto);
        //var_dump($data['datos']);
        if($data['datos']){
            $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteDopingGeneral_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$subcliente.'_'.$proyecto.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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
            foreach($data['datos'] as $row){
                $subcliente = ($row->subcliente != "" && $row->subcliente != null)? $row->subcliente:"-";
                $proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
                $f_doping = $this->reporteFecha($row->creacion);
                $salida .= "<tr><tbody>";
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_doping.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$subcliente.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$proyecto.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->parametros.'</td>';
                $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->codigo_prueba.'</td>';
                $salida .= "</tbody></tr>";
            }
            $salida .= "</table>";
        }
        else{
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
        }
        echo $salida;
    }
    function reporteDopingGeneral_Excel(){
        $datos = $this->uri->segment(3);
        $dato = explode('_', $datos);
        $f_inicio = $dato[0];
        $f_fin = $dato[1];
        $cliente = $dato[2];
        $subcliente = $dato[3];
        $proyecto = $dato[4];
        //var_dump($datos);
        $data['datos'] = $this->reporte_model->reporteDopingGeneral($f_inicio, $f_fin, $cliente, $subcliente, $proyecto);
        if($data['datos']){
            //Se crea objeto de la clase.
            $excel  = new Spreadsheet();
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
            foreach($data['datos'] as $row){
                $subcliente = ($row->subcliente != "" && $row->subcliente != null)? $row->subcliente:"-";
                $proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
                $f_doping = $this->reporteFecha($row->creacion);
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
            $writer = new Xlsx($excel); // instantiate Xlsx
            $filename = 'Reporte3_RegistrosDopinGeneral'; // set filename for excel file to be exported
            //Cabeceras
            header('Content-Type: application/vnd.ms-excel'); // generate excel file
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');	// download file 
        }
        /*else{
            $contador = 2;
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
        }*/
    }
    function reporteFecha($date){
        $f = explode(' ', $date);
        $aux = explode('-', $f[0]);
        $fecha = $aux[2].'/'.$aux[1].'/'.$aux[0];
        $fecha .= " ".$f[1];
        return $fecha;
    }
	function getFechaNacimiento(){
        $id_candidato = $_POST['id_candidato'];
        $f = $this->doping_model->getFechaNacimiento($id_candidato);
        if($f->fecha_nacimiento != ""){
            $aux = explode('-', $f->fecha_nacimiento);
            $fnacimiento = $aux[2].'/'.$aux[1].'/'.$aux[0];
            echo $fnacimiento;
        }
        else{
            echo $fnacimiento = "";
        }
    }

    /*----------------------------------------*/
    /*  Estudios
    /*----------------------------------------*/
      function listado_estudios_index(){
        $datos['clientes'] = $this->funciones_model->getClientesActivos();
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios'] = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach($data['submodulos'] as $row) {
          $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

        $this->load
        ->view('adminpanel/header',$data)
        ->view('adminpanel/scripts',$modales)
        ->view('reportes/listado_estudios',$datos)
        ->view('adminpanel/footer');
      }
      function reporteListadoEstudios(){
				$this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
				$this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
				$this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');

				$this->form_validation->set_message('required','El campo {field} es obligatorio');
				$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

				$msj = array();
				if ($this->form_validation->run() == FALSE) {
					$msj = array(
						'codigo' => 0,
						'msg' => validation_errors()
					);
				} 
				else{
						$f_inicio = fecha_espanol_bd($this->input->post('fi'));
						$f_fin = fecha_espanol_bd($this->input->post('ff'));
						$cliente = $this->input->post('cliente');
						$res = $this->input->post('resultado');
						$estatus = $this->input->post('estatus');
						//$centro_costo = $this->input->post('centro_costo');

						$diaInicio = new DateTime($f_inicio);
						$diaFinal = new DateTime($f_fin);
						if($diaInicio > $diaFinal){
							$msj = array(
								'codigo' => 0,
								'msg' => 'Fechas a filtrar no son válidas'
							);
						}
						else{
              $data['datos'] = $this->reporte_model->reporteListadoEstudios($f_inicio, $f_fin, $cliente, $res, $estatus);
              // if($centro_costo == 'true'){
              //   $encabezado .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Centro de costo</th>';
              // }
							if($data['datos']){
								$salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteListadoEstudios_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$res.'_'.$estatus.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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
								foreach($data['datos'] as $row){
									$f_alta = ($row->fecha_alta != null)? fecha_sinhora_espanol_bd($row->fecha_alta):'-';
									$subcliente = ($row->subcliente != null)? $row->subcliente : '-';
                  $centroCosto = ($row->centro_costo != null)? $row->centro_costo : '-';
                  if($row->proyecto != null){
                    $proyecto = $row->proyecto;
                  }
                  else{
                    if($cliente == 1)
                      $proyecto = 'FACIS';
                    else
                      $proyecto = '';
                  }
                  switch($row->status){
                    case 0:
                    case 1:
                      $estatus = 'EN PROCESO';
                      $f_final = '-';
                      break;
                    case 2:
                      if($row->fechaFinal != null){
												$estatus = 'FINALIZADO';
												$f_final = fecha_sinhora_espanol_bd($row->fechaFinal);
                      }
                      if($row->fechaBGC != null){
												$estatus = 'FINALIZADO';
												$f_final = fecha_sinhora_espanol_bd($row->fechaBGC);
                      }
											if($row->fechaFinal == null && $row->fechaBGC == null){
												$estatus = 'EN PROCESO';
												$f_final = '-';
                      }
                      break;
                  }
                  switch($row->status_bgc){
                    case 1:
                      $bgc = 'RECOMENDABLE'; break;
                    case 2:
                      $bgc = 'NO RECOMENDABLE'; break;
                    case 3:
                      $bgc = 'A CONSIDERACIÓN'; break;
                    case 4:
                      $bgc = 'REFERENCIAS VALIDADAS'; break;
                    case 5:
                      $bgc = 'REFERENCIAS CON INCONSISTENCIAS'; break;
                    default:
                      $bgc = 'NO FINALIZADO'; break;
                  }
									//
									$salida .= "<tr><tbody>";
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$subcliente.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$proyecto.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$estatus.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$bgc.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$centroCosto.'</td>';
									$salida .= "</tbody></tr>";
								}
								$salida .= "</table>";
							}
							else{
								$salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
							}
							$msj = array(
								'codigo' => 1,
								'msg' => $salida
							);
						}   
						
				}
				echo json_encode($msj);
			}
      function reporteListadoEstudios_Excel(){
				$datos = $this->uri->segment(3);
				$dato = explode('_', $datos);
				$f_inicio = $dato[0];
				$f_fin = $dato[1];
				$cliente = $dato[2];
				$res = $dato[3];
				$estatus = $dato[4];

        $data['datos'] = $this->reporte_model->reporteListadoEstudios($f_inicio, $f_fin, $cliente, $res, $estatus);
        
				if($data['datos']){
					//Se crea objeto de la clase.
					$excel  = new Spreadsheet();
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
					foreach($data['datos'] as $row){
            $f_alta = ($row->fecha_alta != null)? fecha_sinhora_espanol_bd($row->fecha_alta):'-';
            $subcliente = ($row->subcliente != null)? $row->subcliente : '-';
            $centroCosto = ($row->centro_costo != null)? $row->centro_costo : '-';
            if($row->proyecto != null){
              $proyecto = $row->proyecto;
            }
            else{
              if($cliente == 1)
                $proyecto = 'FACIS';
              else
                $proyecto = '';
            }
            switch($row->status){
              case 0:
              case 1:
                $estatus = 'EN PROCESO';
                $f_final = '-';
                break;
              case 2:
                $estatus = 'FINALIZADO';
                if($row->fechaFinal != null){
                  $f_final = fecha_sinhora_espanol_bd($row->fechaFinal);
                }
                if($row->fechaBGC != null){
                  $f_final = fecha_sinhora_espanol_bd($row->fechaBGC);
                }
                break;
            }
            switch($row->status_bgc){
              case 1:
                $bgc = 'RECOMENDABLE'; break;
              case 2:
                $bgc = 'NO RECOMENDABLE'; break;
              case 3:
                $bgc = 'A CONSIDERACIÓN'; break;
              case 4:
                $bgc = 'REFERENCIAS VALIDADAS'; break;
              case 5:
                $bgc = 'REFERENCIAS CON INCONSISTENCIAS'; break;
              default:
                $bgc = 'NO FINALIZADO'; break;
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
					$writer = new Xlsx($excel); // instantiate Xlsx
					$filename = 'Reporte_Estudios'; // set filename for excel file to be exported
					//Cabeceras
					header('Content-Type: application/vnd.ms-excel'); // generate excel file
					header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
					header('Cache-Control: max-age=0');
					
					$writer->save('php://output');	// download file 
				}
			}
    /*----------------------------------------*/
    /*  SLA
    /*----------------------------------------*/
			function sla_ingles_index(){
				$datos['clientes'] = $this->funciones_model->getClientesInglesActivos();
				$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
				$datos['usuarios'] = $this->usuario_model->getUsuarios();
				$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
				foreach($data['submodulos'] as $row) {
					$items[] = $row->id_submodulo;
				}
				$data['submenus'] = $items;
				$config = $this->funciones_model->getConfiguraciones();
				$data['version'] = $config->version_sistema;
				//Modals
				$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

				$this->load
				->view('adminpanel/header',$data)
				->view('adminpanel/scripts',$modales)
				->view('reportes/sla_ingles',$datos)
				->view('adminpanel/footer');
			}
			function reporteSLAIngles(){
				$this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
				$this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
				$this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');
				$this->form_validation->set_rules('finalizado', '¿Se requiere proceso finalizado?', 'required|trim');

				$this->form_validation->set_message('required','El campo {field} es obligatorio');
				$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

				$msj = array();
				if ($this->form_validation->run() == FALSE) {
					$msj = array(
						'codigo' => 0,
						'msg' => validation_errors()
					);
				} 
				else{
					$f_inicio = fecha_espanol_bd($this->input->post('fi'));
					$f_fin = fecha_espanol_bd($this->input->post('ff'));
					$cliente = $this->input->post('cliente');
					$finalizado = $this->input->post('finalizado');

					$diaInicio = new DateTime($f_inicio);
					$diaFinal = new DateTime($f_fin);
					if($diaInicio > $diaFinal){
						$msj = array(
							'codigo' => 0,
							'msg' => 'Fechas a filtrar no son válidas'
						);
					}
					else{
						$data['datos'] = $this->reporte_model->reporteSLAIngles($f_inicio, $f_fin, $cliente, $finalizado);
						if($data['datos']){
							$salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteSLAIngles_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$finalizado.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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
							foreach($data['datos'] as $row){
								$proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
								$f_alta = ($row->fecha_alta != null)? fecha_sinhora_ingles_front($row->fecha_alta):'-';
								$f_form = ($row->fecha_contestado != null)? fecha_sinhora_ingles_front($row->fecha_contestado):'-';
								$f_docs = ($row->fecha_documentos != null)? fecha_sinhora_ingles_front($row->fecha_documentos):'-';
								$f_inicio = ($row->fecha_inicio != null)? fecha_sinhora_ingles_front($row->fecha_inicio):'-';
								$f_final = ($row->fecha_final != null)? fecha_sinhora_ingles_front($row->fecha_final):'-';
								$res = ($row->status == 2)? 'Finished':"In process";
								//Calculo de dias transcurridos o SLA
								$dias = 0;
								$acum = 0;
								$fecha_registro = ($row->fecha_inicio != null)? $row->fecha_inicio:$row->fecha_alta; //alta del candidato o fecha inicio del proceso
								$alta = explode(' ', $fecha_registro);
								$fecha_fija = $alta[0].' 16:00:00';//hora limite para iniciar el contador de dias en 1
								$fr = strtotime($fecha_registro);
								$ff = strtotime($fecha_fija);
								if($fr < $ff){
										$dias = 1;//Si la fecha de registro es menor a la hora limite se inicia el dia en 1
								}
								$data['festivas'] = $this->funciones_model->getFechasFestivas();
								//Verificacion del contador de dias con la fecha de regitro
								$num_dia = date('N', $fr);
								if($num_dia != 6 && $num_dia != 7){//Se evalua si el registro no fue hecho un sabado o domingo
									$f_aux = strtotime($alta[0]);
									foreach($data['festivas'] as $festiva){
										$aux = explode(' ', $festiva->fecha);
										$fecha_festiva = strtotime($aux[0]);//Se extraen o definen los dias festivos
										if($f_aux == $fecha_festiva){//Se evalua si cada fecha festiva es diferente a la fecha de regitro
											$dias = 0;
											break;
										}
									}
								}
								$fecha_final = $row->fecha_final;//la fecha final es la fecha de creacion de la tabla candidato_bgc
								//Se consulta si existe registro del candidato en la tabla candidato_bgc
								if($fecha_final != null){
									$fin = explode(' ', $fecha_final);
									$date1 = new DateTime($alta[0]);//Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
									$date2 = new DateTime($fin[0]);//fecha final
									$diff = $date1->diff($date2);
									if($diff->days != 0){
										for($i = 1; $i <= $diff->days; $i++){
											$acum = 0;
											$siguiente = date("Y-m-d",strtotime(date($alta[0])."+ ".$i." days")); //dia siguiente suponiendo que sea el actual en ese momento
											$sig = strtotime($siguiente);
											$num_sig = date('N', $sig);
											if($num_sig != 6 && $num_sig != 7){//Se evalua si el registro no fue hecho un sabado o domingo
												foreach($data['festivas'] as $festiva){//Se extraen o definen los dias festivos
													$aux = explode(' ', $festiva->fecha);
													$fecha_festiva = strtotime($aux[0]);
													if($sig == $fecha_festiva){
														$acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
													}
												}
												if($acum == 0){
													$dias++;//SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
												}
											}
										}
									}
								}
								else{//Sin fecha de finalizacion de estudio
									$date1 = new DateTime($alta[0]);//Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
									$date2 = new DateTime();//fecha actual
									$date2->format('d/m/Y');
									$diff = $date1->diff($date2);
									if($diff->days != 0){
										for($i = 1; $i <= $diff->days; $i++){
											$acum = 0;
											$siguiente = date("Y-m-d",strtotime(date($alta[0])."+ ".$i." days")); //dia siguiente suponiendo que sea el actual en ese momento
											$sig = strtotime($siguiente);
											$num_sig = date('N', $sig);
											if($num_sig != 6 && $num_sig != 7){//Se evalua si el registro no fue hecho un sabado o domingo
												foreach($data['festivas'] as $festiva){//Se extraen o definen los dias festivos
													$aux = explode(' ', $festiva->fecha);
													$fecha_festiva = strtotime($aux[0]);
													if($sig == $fecha_festiva){
														$acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
													}
												}
												if($acum == 0){
													$dias++;//SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
												}
											}
										}
									}
								}
								//
								$salida .= "<tr><tbody>";
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_form.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_docs.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_inicio.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_final.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$dias.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$res.'</td>';
								$salida .= "</tbody></tr>";
							}
							$salida .= "</table>";
						}
						else{
							$salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
						}
						$msj = array(
							'codigo' => 1,
							'msg' => $salida
						);
					}   
				}
				echo json_encode($msj);
			}
			function reporteSLAIngles_Excel(){
					$datos = $this->uri->segment(3);
					$dato = explode('_', $datos);
					$f_inicio = $dato[0];
					$f_fin = $dato[1];
					$cliente = $dato[2];
					$finalizado = $dato[3];

					$data['datos'] = $this->reporte_model->reporteSLAIngles($f_inicio, $f_fin, $cliente, $finalizado);
					if($data['datos']){
							//Se crea objeto de la clase.
							$excel  = new Spreadsheet();
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
							foreach($data['datos'] as $row){
									$proyecto = ($row->proyecto != "" && $row->proyecto != null)? $row->proyecto:"-";
									$f_alta = ($row->fecha_alta != null)? fecha_sinhora_ingles_front($row->fecha_alta):'-';
									$f_form = ($row->fecha_contestado != null)? fecha_sinhora_ingles_front($row->fecha_contestado):'-';
									$f_docs = ($row->fecha_documentos != null)? fecha_sinhora_ingles_front($row->fecha_documentos):'-';
									$f_inicio = ($row->fecha_inicio != null)? fecha_sinhora_ingles_front($row->fecha_inicio):'-';
									$f_final = ($row->fecha_final != null)? fecha_sinhora_ingles_front($row->fecha_final):'-';
									$res = ($row->status == 2)? 'Finished':"In process";
									//Calculo de dias transcurridos o SLA
									$dias = 0;
									$acum = 0;
									$fecha_registro = ($row->fecha_inicio != null)? $row->fecha_inicio:$row->fecha_alta; //alta del candidato o fecha inicio del proceso
									$alta = explode(' ', $fecha_registro);
									$fecha_fija = $alta[0].' 16:00:00';//hora limite para iniciar el contador de dias en 1
									$fr = strtotime($fecha_registro);
									$ff = strtotime($fecha_fija);
									if($fr < $ff){
											$dias = 1;//Si la fecha de registro es menor a la hora limite se inicia el dia en 1
									}
									$data['festivas'] = $this->funciones_model->getFechasFestivas();
									//Verificacion del contador de dias con la fecha de regitro
									$num_dia = date('N', $fr);
									if($num_dia != 6 && $num_dia != 7){//Se evalua si el registro no fue hecho un sabado o domingo
											$f_aux = strtotime($alta[0]);
											foreach($data['festivas'] as $festiva){
													$aux = explode(' ', $festiva->fecha);
													$fecha_festiva = strtotime($aux[0]);//Se extraen o definen los dias festivos
													if($f_aux == $fecha_festiva){//Se evalua si cada fecha festiva es diferente a la fecha de regitro
															$dias = 0;
															break;
													}
											}
									}
									$fecha_final = $row->fecha_final;//la fecha final es la fecha de creacion de la tabla candidato_bgc
									//Se consulta si existe registro del candidato en la tabla candidato_bgc
									if($fecha_final != null){
											$fin = explode(' ', $fecha_final);
											$date1 = new DateTime($alta[0]);//Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
											$date2 = new DateTime($fin[0]);//fecha final
											$diff = $date1->diff($date2);
											if($diff->days != 0){
													for($i = 1; $i <= $diff->days; $i++){
															$acum = 0;
															$siguiente = date("Y-m-d",strtotime(date($alta[0])."+ ".$i." days")); //dia siguiente suponiendo que sea el actual en ese momento
															$sig = strtotime($siguiente);
															$num_sig = date('N', $sig);
															if($num_sig != 6 && $num_sig != 7){//Se evalua si el registro no fue hecho un sabado o domingo
																	foreach($data['festivas'] as $festiva){//Se extraen o definen los dias festivos
																			$aux = explode(' ', $festiva->fecha);
																			$fecha_festiva = strtotime($aux[0]);
																			if($sig == $fecha_festiva){
																					$acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
																			}
																	}
																	if($acum == 0){
																			$dias++;//SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
																	}
															}
													}
											}
									}
									else{//Sin fecha de finalizacion de estudio
											$date1 = new DateTime($alta[0]);//Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
											$date2 = new DateTime();//fecha actual
											$date2->format('d/m/Y');
											$diff = $date1->diff($date2);
											if($diff->days != 0){
													for($i = 1; $i <= $diff->days; $i++){
															$acum = 0;
															$siguiente = date("Y-m-d",strtotime(date($alta[0])."+ ".$i." days")); //dia siguiente suponiendo que sea el actual en ese momento
															$sig = strtotime($siguiente);
															$num_sig = date('N', $sig);
															if($num_sig != 6 && $num_sig != 7){//Se evalua si el registro no fue hecho un sabado o domingo
																	foreach($data['festivas'] as $festiva){//Se extraen o definen los dias festivos
																			$aux = explode(' ', $festiva->fecha);
																			$fecha_festiva = strtotime($aux[0]);
																			if($sig == $fecha_festiva){
																					$acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
																			}
																	}
																	if($acum == 0){
																			$dias++;//SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
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
							$writer = new Xlsx($excel); // instantiate Xlsx
							$filename = 'Reporte_SLAIngles'; // set filename for excel file to be exported
							//Cabeceras
							header('Content-Type: application/vnd.ms-excel'); // generate excel file
							header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
							header('Cache-Control: max-age=0');
							
							$writer->save('php://output');	// download file 
					}
					/*else{
							$contador = 2;
							$this->excel->getActiveSheet()->setCellValue("A{$contador}", "SIN REGISTROS");
					}*/
			}
    /*----------------------------------------*/
    /*  Listado Doping
    /*----------------------------------------*/
    	function listado_doping_index(){
        $datos['clientes'] = $this->funciones_model->getClientesActivos();
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $datos['usuarios'] = $this->usuario_model->getUsuarios();
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
				foreach($data['submodulos'] as $row) {
					$items[] = $row->id_submodulo;
				}
				$data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

        $this->load
        ->view('adminpanel/header',$data)
        ->view('adminpanel/scripts',$modales)
        ->view('reportes/listado_doping',$datos)
        ->view('adminpanel/footer');
    	}
			function reporteListadoDoping(){
				$this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
				$this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');
				$this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');

				$this->form_validation->set_message('required','El campo {field} es obligatorio');
				$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

				$msj = array();
				if ($this->form_validation->run() == FALSE) {
					$msj = array(
						'codigo' => 0,
						'msg' => validation_errors()
					);
				} 
				else{
						$f_inicio = fecha_espanol_bd($this->input->post('fi'));
						$f_fin = fecha_espanol_bd($this->input->post('ff'));
						$cliente = $this->input->post('cliente');
						$res = $this->input->post('resultado');

						$diaInicio = new DateTime($f_inicio);
						$diaFinal = new DateTime($f_fin);
						if($diaInicio > $diaFinal){
							$msj = array(
								'codigo' => 0,
								'msg' => 'Fechas a filtrar no son válidas'
							);
						}
						else{
							if($res == ''){
								$data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
							}
							else{
								$data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
							}
							if($data['datos']){
								$salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteListadoDoping_Excel/'.$f_inicio.'_'.$f_fin.'_'.$cliente.'_'.$res.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
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
								foreach($data['datos'] as $row){
									$f_alta = ($row->fecha_alta != null)? fecha_sinhora_espanol_bd($row->fecha_alta):'-';
									if($row->tipo_antidoping == 1){
										$f_doping = ($row->fecha_doping != null)? fecha_sinhora_espanol_bd($row->fecha_doping):'PENDIENTE';
										$f_res = ($row->fecha_resultado != null)? fecha_sinhora_espanol_bd($row->fecha_resultado):'PENDIENTE';
										$examen = ($row->examen != null)? $row->examen:'-';
										$conjunto = ($row->conjunto != null)? $row->conjunto:'-';
										if($row->resultado != null){
											if($row->resultado != -1){
												$resultado = ($row->resultado == 1)? 'POSITIVO':'NEGATIVO';
											}
											else{
												$resultado = 'PENDIENTE';
											}
										}
										else{
											$resultado = 'PENDIENTE';
										}
									}
									else{
										$f_doping = 'N/A';
										$f_res = 'N/A';
										$resultado = 'N/A';
										$examen = 'N/A';
										$conjunto = 'N/A';
									}
									//
									$salida .= "<tr><tbody>";
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->cliente.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->candidato.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$examen.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$conjunto.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_doping.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$resultado.'</td>';
									$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_res.'</td>';
									$salida .= "</tbody></tr>";
								}
								$salida .= "</table>";
							}
							else{
								$salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
							}
							$msj = array(
								'codigo' => 1,
								'msg' => $salida
							);
						}   
						
				}
				echo json_encode($msj);
			}
			function reporteListadoDoping_Excel(){
				$datos = $this->uri->segment(3);
				$dato = explode('_', $datos);
				$f_inicio = $dato[0];
				$f_fin = $dato[1];
				$cliente = $dato[2];
				$res = $dato[3];

				if($res == ''){
					$data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
				}
				else{
					$data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
				}
				if($data['datos']){
					//Se crea objeto de la clase.
					$excel  = new Spreadsheet();
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
					foreach($data['datos'] as $row){
						$f_alta = ($row->fecha_alta != null)? fecha_sinhora_espanol_bd($row->fecha_alta):'-';
						if($row->tipo_antidoping == 1){
							$f_doping = ($row->fecha_doping != null)? fecha_sinhora_espanol_bd($row->fecha_doping):'PENDIENTE';
							$f_res = ($row->fecha_resultado != null)? fecha_sinhora_espanol_bd($row->fecha_resultado):'PENDIENTE';
							$examen = ($row->examen != null)? $row->examen:'-';
							$conjunto = ($row->conjunto != null)? $row->conjunto:'-';
							if($row->resultado != null){
								if($row->resultado != -1){
									$resultado = ($row->resultado == 1)? 'POSITIVO':'NEGATIVO';
								}
								else{
									$resultado = 'PENDIENTE';
								}
							}
							else{
								$resultado = 'PENDIENTE';
							}
						}
						else{
							$f_doping = 'N/A';
							$f_res = 'N/A';
							$resultado = 'N/A';
							$examen = 'N/A';
							$conjunto = 'N/A';
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
					$writer = new Xlsx($excel); // instantiate Xlsx
					$filename = 'Reporte_ListadoDoping'; // set filename for excel file to be exported
					//Cabeceras
					header('Content-Type: application/vnd.ms-excel'); // generate excel file
					header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
					header('Cache-Control: max-age=0');
					
					$writer->save('php://output');	// download file 
				}
			}
		/*----------------------------------------*/
    /*  Listado Clientes
    /*----------------------------------------*/
			function listado_clientes_index(){
				$datos['clientes'] = $this->cat_cliente_model->getActivos();
				$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
				$datos['usuarios'] = $this->usuario_model->getUsuarios();
				$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
				foreach($data['submodulos'] as $row) {
					$items[] = $row->id_submodulo;
				}
				$data['submenus'] = $items;
				$config = $this->funciones_model->getConfiguraciones();
				$data['version'] = $config->version_sistema;
				//Modals
				$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

				$this->load
				->view('adminpanel/header',$data)
				->view('adminpanel/scripts',$modales)
				->view('reportes/listado_clientes',$datos)
				->view('adminpanel/footer');
			}
			function reporteListadoClientes(){
				/*$this->form_validation->set_rules('fi', 'Fecha de inicio', 'required|trim');
				$this->form_validation->set_rules('ff', 'Fecha final', 'required|trim');*/
				$this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');

				$this->form_validation->set_message('required','El campo {field} es obligatorio');
				$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

				$msj = array();
				if ($this->form_validation->run() == FALSE) {
					$msj = array(
						'codigo' => 0,
						'msg' => validation_errors()
					);
				} 
				else{
					//$f_inicio = fecha_espanol_bd($this->input->post('fi'));
					//$f_fin = fecha_espanol_bd($this->input->post('ff'));
					$cliente = $this->input->post('cliente');
				//	$res = $this->input->post('resultado');

					/*$diaInicio = new DateTime($f_inicio);
					$diaFinal = new DateTime($f_fin);
					if($diaInicio > $diaFinal){
						$msj = array(
							'codigo' => 0,
							'msg' => 'Fechas a filtrar no son válidas'
						);
					}
					else{*/
						/*if($res == ''){
							$data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
						}
						else{
							$data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
						}*/
						$data['datos'] = $this->reporte_model->reporteListadoDopingClientes($cliente);
						if($data['datos']){
							$salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteListadoClientes_Excel/'.$cliente.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
							$salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
							$salida .= '<tr>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Empresa</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Razón social</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">En inglés</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Clave</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha Alta</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Subcliente</th>';
							$salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Clave</th>';
							$salida .= '</tr>';
							foreach($data['datos'] as $row){
								$f_alta = ($row->creacion != null)? fecha_sinhora_espanol_bd($row->creacion):'-';
								$ingles = ($row->ingles == 1)? 'SÍ' : 'NO';
								$razon_social = ($row->razon_social != '' && $row->razon_social != NULL)? $row->razon_social : 'Sin registro';
								$subcliente = ($row->subcliente == NULL)? 'Sin registro' : $row->subcliente;
								$claveSubcliente = ($row->subcliente == NULL)? 'Sin registro' : $row->claveSubcliente;
								//
								$salida .= "<tr><tbody>";
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->nombre.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$razon_social.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$ingles.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->clave.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_alta.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$subcliente.'</td>';
								$salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$claveSubcliente.'</td>';
								$salida .= "</tbody></tr>";
							}
							$salida .= "</table>";
						}
						else{
							$salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
						}
						$msj = array(
							'codigo' => 1,
							'msg' => $salida
						);
					//}   
				}
				echo json_encode($msj);
			}
			function reporteListadoClientes_Excel(){
				$datos = $this->uri->segment(3);
				$dato = explode('_', $datos);
				//$f_inicio = $dato[0];
				//$f_fin = $dato[1];
				$cliente = $dato[0];
				//$res = $dato[3];

				/*if($res == ''){
					$data['datos'] = $this->reporte_model->reporteListadoDopingTodos($f_inicio, $f_fin, $cliente);
				}
				else{
					$data['datos'] = $this->reporte_model->reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res);
				}*/
				$data['datos'] = $this->reporte_model->reporteListadoDopingClientes($cliente);
				if($data['datos']){
					//Se crea objeto de la clase.
					$excel  = new Spreadsheet();
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
					
					//Le aplicamos negrita a los títulos de la cabecera.
					$excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
					
					//Definimos los títulos de la cabecera.
					$excel->getActiveSheet()->setCellValue("A{$contador}", 'EMPRESA');
					$excel->getActiveSheet()->setCellValue("B{$contador}", 'RAZÓN SOCIAL');
					$excel->getActiveSheet()->setCellValue("C{$contador}", 'EN INGLÉS');
					$excel->getActiveSheet()->setCellValue("D{$contador}", 'CLAVE');
					$excel->getActiveSheet()->setCellValue("E{$contador}", 'FECHA ALTA');
					$excel->getActiveSheet()->setCellValue("F{$contador}", 'SUBCLIENTE');
					$excel->getActiveSheet()->setCellValue("G{$contador}", 'CLAVE');
					
					//Definimos la data del cuerpo.        
					foreach($data['datos'] as $row){
						$f_alta = ($row->creacion != null)? fecha_sinhora_espanol_bd($row->creacion):'-';
						$ingles = ($row->ingles == 1)? 'SÍ' : 'NO';
						$razon_social = ($row->razon_social != '' && $row->razon_social != NULL)? $row->razon_social : 'Sin registro';
						$subcliente = ($row->subcliente == NULL)? 'Sin registro' : $row->subcliente;
						$claveSubcliente = ($row->subcliente == NULL)? 'Sin registro' : $row->claveSubcliente;
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$excel->getActiveSheet()->setCellValue("A{$contador}", $row->nombre);
						$excel->getActiveSheet()->setCellValue("B{$contador}", $razon_social);
						$excel->getActiveSheet()->setCellValue("C{$contador}", $ingles);
						$excel->getActiveSheet()->setCellValue("D{$contador}", $row->clave);
						$excel->getActiveSheet()->setCellValue("E{$contador}", $f_alta);
						$excel->getActiveSheet()->setCellValue("F{$contador}", $subcliente);
						$excel->getActiveSheet()->setCellValue("G{$contador}", $claveSubcliente);
					}
					//Creamos objeto para crear el archivo y definimos un nombre de archivo
					$writer = new Xlsx($excel); // instantiate Xlsx
					$filename = 'Reporte_ListadoClientes'; // set filename for excel file to be exported
					//Cabeceras
					header('Content-Type: application/vnd.ms-excel'); // generate excel file
					header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
					header('Cache-Control: max-age=0');
					
					$writer->save('php://output');	// download file 
				}
			}
    /*----------------------------------------*/
    /*  Proceso de Reclutamiento
    /*----------------------------------------*/
			function proceso_reclutamiento_index(){
				$datos['usuarios'] = $this->usuario_model->getTipoUsuarios([4,11]);
				$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
				$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
				foreach($data['submodulos'] as $row) {
					$items[] = $row->id_submodulo;
				}
				$data['submenus'] = $items;
				$config = $this->funciones_model->getConfiguraciones();
				$data['version'] = $config->version_sistema;
				//Modals
				$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

				$this->load
				->view('adminpanel/header',$data)
				->view('adminpanel/scripts',$modales)
				->view('reportes/proceso_reclutamiento',$datos)
				->view('adminpanel/footer');
			}
			function reporteProcesoReclutamiento(){
        $this->form_validation->set_rules('fecha_inicio', 'Fecha de inicio', 'required|trim');
				$this->form_validation->set_rules('fecha_fin', 'Fecha final', 'required|trim');
				$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');

				$this->form_validation->set_message('required','El campo {field} es obligatorio');
				$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

				$msj = array();
				if ($this->form_validation->run() == FALSE) {
					$msj = array(
						'codigo' => 0,
						'msg' => validation_errors()
					);
				} 
				else{
          $f_inicio = $this->input->post('fecha_inicio');
          $f_fin = $this->input->post('fecha_fin');
					$usuario = $this->input->post('usuario');
          $data['datos'] = $this->reporte_model->reporteProcesoReclutamiento($f_inicio, $f_fin, $usuario);
          if($data['datos']){
            $salida = '<div style="text-align:center;margin-bottom:50px;"><a class="btn btn-success" href="'.base_url().'Reporte/reporteProcesoReclutamiento_Excel/'.$f_inicio.'_'.$f_fin.'_'.$usuario.'" target="_blank"><i class="fas fa-file-excel"></i> Exportar a Excel</a></div>';
            $salida .= '<table style="border: 0px; border-collapse: collapse;width: 100%;padding:5px;">';
            $salida .= '<tr>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="15%">Reclutador</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha registro</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="15%">Aspirante</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Teléfono</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Domicilio</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Medio de contacto</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Cliente</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="15%">Puesto</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Sueldo</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha requisicion</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Fecha ingreso</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;" width="20%">Garantía</th>';
            $salida .= '<th style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">Pago</th>';
            $salida .= '</tr>';
            foreach($data['datos'] as $row){
              $f_registro = ($row->creacion != null)? fecha_sinhora_espanol_bd($row->creacion):'-';
              $usuario = ($row->usuario != null)? $row->usuario : 'Sin asignar';
              $comercial = ($row->nombre_comercial != null)? ' - '.$row->nombre_comercial : '';
              $cliente = $row->cliente.$comercial;
              $f_requisicion = ($row->fechaRequisicion != null)? fecha_sinhora_espanol_bd($row->fechaRequisicion):'-';
              $sueldo_acordado = ($row->sueldo_acordado != null)? '$'.$row->sueldo_acordado : '-';
              $f_ingreso = ($row->fecha_ingreso != null)? fecha_sinhora_espanol_bd($row->fecha_ingreso):'-';
              $garantia = ($row->garantia != null)? $row->garantia : '-';
              $pago = ($row->pago != null)? $row->pago : '-';
              //
              $salida .= "<tr><tbody>";
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$usuario.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_registro.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->aspirante.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->telefono.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->domicilio.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->medio_contacto.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$cliente.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$row->puesto.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$sueldo_acordado.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_requisicion.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$f_ingreso.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$garantia.'</td>';
              $salida .= '<td style"border: 1px solid #a4a6a5;text-align: left;padding: 6px;">'.$pago.'</td>';
              $salida .= "</tbody></tr>";
            }
            $salida .= "</table>";
          }
          else{
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros de acuerdo a los filtros aplicados</p>';
          }
          $msj = array(
            'codigo' => 1,
            'msg' => $salida
          );
				}
				echo json_encode($msj);
			}
      function reporteProcesoReclutamiento_Excel(){
				$datos = $this->uri->segment(3);
				$dato = explode('_', $datos);
				$f_inicio = $dato[0];
				$f_fin = $dato[1];
				$usuario = $dato[2];
        $data['datos'] = $this->reporte_model->reporteProcesoReclutamiento($f_inicio, $f_fin, $usuario);

				if($data['datos']){
					//Se crea objeto de la clase.
					$excel  = new Spreadsheet();
					//Contador de filas
					$contador = 1;
					//Le aplicamos ancho las columnas.
					// Tambien podria acotarse esta parte $variable = $excel->getActiveSheet();
					//Le aplicamos ancho las columnas.
					$excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
					$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
					$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
					$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
					$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
					$excel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
					$excel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
					$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
					$excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
					$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
					$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
					$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
					
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
					$excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("L{$contador}")->getFont()->setBold(true);
					$excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
					
					//Definimos los títulos de la cabecera.
					$excel->getActiveSheet()->setCellValue("A{$contador}", 'RECLUTADOR');
					$excel->getActiveSheet()->setCellValue("B{$contador}", 'FECHA REGISTRO');
					$excel->getActiveSheet()->setCellValue("C{$contador}", 'ASPIRANTE');
					$excel->getActiveSheet()->setCellValue("D{$contador}", 'TELEFONO');
					$excel->getActiveSheet()->setCellValue("E{$contador}", 'DOMICILIO');
					$excel->getActiveSheet()->setCellValue("F{$contador}", 'MEDIO DE CONTACTO');
					$excel->getActiveSheet()->setCellValue("G{$contador}", 'CLIENTE');
					$excel->getActiveSheet()->setCellValue("H{$contador}", 'PUESTO');
					$excel->getActiveSheet()->setCellValue("I{$contador}", 'SUELDO');
					$excel->getActiveSheet()->setCellValue("J{$contador}", 'FECHA REQUISICION');
					$excel->getActiveSheet()->setCellValue("K{$contador}", 'FECHA INGRESO');
					$excel->getActiveSheet()->setCellValue("L{$contador}", 'GARANTÍA');
					$excel->getActiveSheet()->setCellValue("M{$contador}", 'PAGO');
					
					//Definimos la data del cuerpo.        
					foreach($data['datos'] as $row){
						$f_registro = ($row->creacion != null)? fecha_sinhora_espanol_bd($row->creacion):'-';
            $usuario = ($row->usuario != null)? $row->usuario : 'Sin asignar';
            $comercial = ($row->nombre_comercial != null)? ' - '.$row->nombre_comercial : '';
            $cliente = $row->cliente.$comercial;
            $f_requisicion = ($row->fechaRequisicion != null)? fecha_sinhora_espanol_bd($row->fechaRequisicion):'-';
            $sueldo_acordado = ($row->sueldo_acordado != null)? '$'.$row->sueldo_acordado : '-';
            $f_ingreso = ($row->fecha_ingreso != null)? fecha_sinhora_espanol_bd($row->fecha_ingreso):'-';
            $garantia = ($row->garantia != null)? $row->garantia : '-';
            $pago = ($row->pago != null)? $row->pago : '-';
						//Incrementamos una fila más, para ir a la siguiente.
						$contador++;
						//Informacion de las filas de la consulta.
						$excel->getActiveSheet()->setCellValue("A{$contador}", $usuario);
						$excel->getActiveSheet()->setCellValue("B{$contador}", $f_registro);
						$excel->getActiveSheet()->setCellValue("C{$contador}", $row->aspirante);
						$excel->getActiveSheet()->setCellValue("D{$contador}", $row->telefono);
						$excel->getActiveSheet()->setCellValue("E{$contador}", $row->domicilio);
						$excel->getActiveSheet()->setCellValue("F{$contador}", $row->medio_contacto);
						$excel->getActiveSheet()->setCellValue("G{$contador}", $cliente);
						$excel->getActiveSheet()->setCellValue("H{$contador}", $row->puesto);
						$excel->getActiveSheet()->setCellValue("I{$contador}", $sueldo_acordado);
						$excel->getActiveSheet()->setCellValue("J{$contador}", $f_requisicion);
						$excel->getActiveSheet()->setCellValue("K{$contador}", $f_ingreso);
						$excel->getActiveSheet()->setCellValue("L{$contador}", $garantia);
						$excel->getActiveSheet()->setCellValue("M{$contador}", $pago);
					}
					//Creamos objeto para crear el archivo y definimos un nombre de archivo
					$writer = new Xlsx($excel); // instantiate Xlsx
					$filename = 'Reporte_Procesos_Reclutamiento'; // set filename for excel file to be exported
					//Cabeceras
					header('Content-Type: application/vnd.ms-excel'); // generate excel file
					header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
					header('Cache-Control: max-age=0');
					
					$writer->save('php://output');	// download file 
				}
			}
}   	