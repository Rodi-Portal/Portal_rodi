<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function generarPassword(){
    //Se define una cadena de caractares.
    //Os recomiendo desordenar las minúsculas, mayúsculas y números para mejorar la probabilidad.
    $cadena = "A1BCDEFGHI2JKLMNO3PQRST4UV5WXYZabc6defgh7ijk8lmn9opqr0stuvwxyz";
    $cadenaSimbolos ="!$*#&?";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
    $longitudSimbolos=strlen($cadenaSimbolos);
    //Definimos la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, puedes poner la longitud que necesites
    //Se debe tener en cuenta que cuanto más larga sea más segura será.
    $longitudPass=10;
  
    //Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
  
        //Vamos formando la contraseña con cada carácter aleatorio.
        $pass .= substr($cadena,$pos,1);
    }

    for($i=1 ; $i<=2 ; $i++){
      //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
      $pos=rand(0,$longitudSimbolos-1);

      //Vamos formando la contraseña con cada carácter aleatorio.
      $pass .= substr($cadenaSimbolos,$pos,1);
  } 
  echo $pass;
    
    
  }
  
  function getPaises(){
    $res = $this->funciones_model->getPaises();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getEstados(){
    $res = $this->funciones_model->getEstados();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getGradosEstudio(){
    $res = $this->funciones_model->getGradosEstudio();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getCiviles(){
    $res = $this->funciones_model->getCiviles();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getGruposSanguineo(){
    $res = $this->funciones_model->getGruposSanguineos();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getMediosTransporte(){
    $res = $this->funciones_model->getMediosTransporte();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getTiposIdentificacion(){
    $res = $this->funciones_model->getTiposIdentificacion();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getFrecuencias(){
    $res = $this->funciones_model->getFrecuencias();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getParentescos(){
    $res = $this->funciones_model->getParentescos();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getNivelesZona(){
    $res = $this->funciones_model->getNivelesZona();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getTiposVivienda(){
    $res = $this->funciones_model->getTiposVivienda();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getCondicionesVivienda(){
    $res = $this->funciones_model->getCondicionesVivienda();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getEscolaridades(){
    $res = $this->funciones_model->getEscolaridades();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
}