<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visita extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getCandidato(){
    $candidato = $this->visita_model->getCandidato($this->input->post('id'));
    $sub = ($candidato->subcliente == "" || $candidato->subcliente == null) ? "" : '/' . $candidato->subcliente;
    $cel = ($candidato->celular == "" || $candidato->celular == null) ? "Sin registro" : $candidato->celular;
    $aux = explode(' ', $candidato->fecha_alta);
    $f = explode('-', $aux[0]);
    $fecha = $f[2] . "/" . $f[1] . "/" . $f[0];
    $h = explode(':', $aux[1]);
    $hora = $h[0] . ":" . $h[1];
    $tiempo = $fecha . " " . $hora;
    if ($candidato->calle != null && $candidato->municipio != null) {
      $domicilio = $candidato->calle . ' #' . $candidato->exterior . ' ' . $candidato->interior . ' ' . $candidato->colonia . ' ' . $candidato->cp . ', ' . $candidato->municipio;
      $calle = str_replace(' ', '+', $candidato->calle);
      $colonia = str_replace(' ', '+', $candidato->colonia);
      $maps = $calle . '+' . $candidato->exterior . '+' . $colonia . '+' . $candidato->cp . '+' . $candidato->municipio;
    } else {
      $domicilio = 'Domicilio sin registrar';
      $maps = '';
    }
    $cand_ingresos = $candidato->ingresos;
    $cand_ingresos_extra = $candidato->ingresos_extra;

    $salida = '<div class="card carta mt-4 mb-4" id='.$candidato->id.'>
      <div class="card-body">
        <div class="row">
          <div class="col-12 text-center">
            <h4 class="card-title mt-2">#'.$candidato->id.' '.$candidato->candidato.'<br>(' . $candidato->cliente . ' ' . $sub . ')</h4>
            <h5>Telefono: ' . $cel .'</h5>
            <h5>'.$domicilio.'</h5>
          </div>
        </div>';
        if($candidato->id_cliente == 51){  
          $salida .= '<div class="alert alert-warning text-center"><p>Favor de tomar las siguientes fotos al(a la) candidato(a): rostro, dentro del domicilio y fuera del domicilio </p></div>
          <div class="row text-center mt-1">';
          if($maps != ''){
            $salida .= '<div class="col-4">
              <a class="icono_modal" href="https://www.google.com/maps/search/'.$maps.'" target="_blank"><i class="fas fa-map-marker-alt"></i><h5>Ver Domicilio</h5></a>
            </div>';
          } 
            $salida .= '<div class="col-4">
              <a class="icono_modal" onclick="openFamiliares('.$candidato->id.',\''.$candidato->candidato.'\')"><i class="fas fa-users"></i><h5>Grupo Familiar</h5></a>
            </div>
            <div class="col-4">
              <a class="icono_modal" onclick="getVivienda('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_vivienda.')"><i class="fas fa-home"></i><h5>Vivienda</h5></a>
            </div>
            <div class="col-4">
              <a class="icono_modal" onclick="getServicios('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_servicio.')"><i class="fas fa-faucet"></i><h5>Servicios públicos</h5></a>
            </div>
            <div class="col-4">
              <a class="icono_modal" onclick="getFinanzas('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_finanzas.')"><i class="fas fa-dollar-sign"></i><h5>Finanzas</h5></a>
            </div>
            <div class="col-4">
              <a class="icono_modal" onclick="getVecinales('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_ref_vecinal.','.$candidato->cantidad_ref_vecinales.')"><i class="fas fa-house-user"></i><h5>Ref. Vecinales</h5></a>
            </div>
            <div class="col-4">
              <a class="icono_modal" onclick="endVisit('.$candidato->id.',\''.$candidato->candidato.'\')"><i class="fas fa-check-circle"></i><h5>Finalizar</h5></a>
            </div>
          </div>';
        }
        else{ 
          $salida .= '<div class="row text-center mt-1">';
            if ($maps != '') { 
              $salida .= '<div class="col-4">
                <a class="icono_modal" href="https://www.google.com/maps/search/'.$maps.'" target="_blank"><i class="fas fa-map-marker-alt"></i><h5>Ver Domicilio</h5></a>
            </div>';
            } 
            if(!empty($candidato->id_vivienda)){
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getVivienda('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_vivienda.')"><i class="fas fa-home"></i><h5>Vivienda</h5></a>
              </div>';
            }
            if(!empty($candidato->id_servicio)){
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getServicios('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_servicio.')"><i class="fas fa-faucet"></i><h5>Servicios públicos</h5></a>
              </div>';
            }
            if(!empty($candidato->id_salud)){
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getSalud('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_salud.')"><i class="fas fa-notes-medical"></i><h5>Estado de salud</h5></a>
              </div>';
            }
            if(!empty($candidato->id_finanzas)){ 
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getFinanzas('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_finanzas.')"><i class="fas fa-dollar-sign"></i><h5>Economía</h5></a>
              </div>';
            }
            if(!empty($candidato->id_seccion_verificacion_docs)){ 
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getDocumentacion('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_seccion_verificacion_docs.')"><i class="fas fa-folder-open"></i><h5>Documentación</h5></a>
              </div>';
            }
            if(!empty($candidato->id_ref_vecinal) && $candidato->cantidad_ref_vecinales > 0){ 
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="getVecinales('.$candidato->id.',\''.$candidato->candidato.'\','.$candidato->id_ref_vecinal.','.$candidato->cantidad_ref_vecinales.')"><i class="fas fa-house-user"></i><h5>Ref. Vecinales</h5></a>
              </div>';
            }
            if ($candidato->id_cliente != 16 && $candidato->id_cliente != 159) { 
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="abrirFormulario('.$candidato->id.',\''.$candidato->candidato.'\')"><i class="fas fa-check-circle"></i><h5>Finalizar</h5></a>
              </div>';
            }
            if ($candidato->id_cliente == 16) {
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="abrirFormularioTipo2('.$candidato->id.',\''.$candidato->candidato.'\')"><i class="fas fa-check-circle"></i><h5>Finalizar</h5></a>
              </div>';
            }
            if ($candidato->id_cliente == 159) { 
              $salida .= '<div class="col-4">
                <a class="icono_modal" onclick="abrirFormularioTipo3('.$candidato->id.',\''.$candidato->candidato.'\')"><i class="fas fa-check-circle"></i><h5>Finalizar</h5></a>
              </div>';
            }
            $salida .= '</div>';
        }
      $salida .= '</div>
    </div>';

    echo $salida;
  }

}
    