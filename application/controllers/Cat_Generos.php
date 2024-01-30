<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_Generos extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function index(){
    $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
    $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
    foreach($data['submodulos'] as $row) {
      $items[] = $row->id_submodulo;
    }
    $data['submenus'] = $items;
    $vista['modals'] = $this->load->view('modals/mdl_catalogos/mdl_cat_puesto','', TRUE);
    $config = $this->funciones_model->getConfiguraciones();
		$data['version'] = $config->version_sistema;

    //Modals
		$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

    $this->load
    ->view('adminpanel/header',$data)
    ->view('adminpanel/scripts',$modales)
    ->view('catalogos/puestos', $vista)
    ->view('adminpanel/footer');
  }
  function getPuestos(){
    $p['recordsTotal'] = $this->cat_generos_model->getTotal();
    $p['recordsFiltered'] = $this->cat_generos_model->getTotal();
    $p['data'] = $this->cat_generos_model->getPuestosActivos();
    $this->output->set_output( json_encode( $p ) );
  } 
  function registrar(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|is_unique[puesto.nombre]');

    $this->form_validation->set_message('required', 'El campo %s es obligatorio');
    $this->form_validation->set_message('is_unique', 'El campo %s debe ser único');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    } else {
      $id_usuario = $this->session->userdata('id');
      $date = date('Y-m-d H:i:s');
      $puesto = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'nombre' => $this->input->post('nombre')
      );
      $this->cat_generos_model->registrar($puesto);
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }
  function editar(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|is_unique[puesto.nombre]');

    $this->form_validation->set_message('required','El campo %s es obligatorio');
    $this->form_validation->set_message('is_unique','El campo %s está repetido o es el mismo a ingresar');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
        $msj = array(
            'codigo' => 0,
            'msg' => validation_errors()
        );
    } 
    else {
        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $puesto = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => $this->input->post('nombre')
        );
        $this->cat_generos_model->editar($puesto, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    echo json_encode($msj);
  }
  function accion(){
    $id_usuario = $this->session->userdata('id');
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $accion = $this->input->post('accion');
    if($accion == "desactivar"){
        $puesto = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 0
        );
        $this->cat_generos_model->editar($puesto, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    if($accion == "activar"){
        $puesto = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 1
        );
        $this->cat_generos_model->editar($puesto, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    if($accion == "eliminar"){
        $puesto = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'eliminado' => 1
        );
        $this->cat_generos_model->editar($puesto, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    echo json_encode($msj);
  }
  function uploadCSV(){
    if(isset($_FILES["archivo"]["name"])) {
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $id_candidato = $this->input->post('id_candidato');
      $id_usuario = $this->session->userdata('id');

      $rows     = [];
      $file     = $_FILES["archivo"];
      $tmp      = $file["tmp_name"];
      $filename = $file["name"];
      $size     = $file["size"];

      if ($size < 0) {
        $msj = array(
          'codigo' => 2,
          'msg' => 'Seleccione un archivo válido'
        );
      }
      else{
        $handle = fopen($tmp, "r");
 
        while (($data = fgetcsv($handle)) !== false) {
          $rows[] = $data;
        }
  
        unset($rows[0]); // se eliminan las cabeceras
        $total = count($rows);
        
        if ($total <= 0) {
          $msj = array(
            'codigo' => 2,
            'msg' => 'Seleccione un archivo válido'
          );
        }
        else{
          //var_dump($rows);
          foreach($rows as $r){
            if($r[0] != ''){
              $puesto = ucfirst(strtolower($r[0]));
              $hayId = $this->cat_generos_model->check($puesto);
              if($hayId == 0){
                $data = array(
                  'creacion' => $date,
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'nombre' => $puesto
                );
                $this->cat_generos_model->registrar($data);
              }
            }
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'Success'
          );
        }
      }
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Seleccione un archivo válido'
      );
    }
    echo json_encode($msj);
  }
  function getPositionByName(){
    $existPosition = $this->cat_generos_model->getPositionByName($this->input->post('nombre'));
    $date = date('Y-m-d H:i:s');
    $id_usuario = $this->session->userdata('id');
    if($existPosition == NULL){
      $position = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'nombre' => $this->input->post('nombre')
      );
      $id = $this->cat_generos_model->addPositionWithIdReturned($position);
    }else{
      $id = $existPosition->id;
    }
    echo $id;
  }
  function getAllPositions(){
    $res = $this->cat_generos_model->getAllPositions();
    if($res != NULL){
      echo json_encode($res);
    }else{
      echo $res = 0;
    }
  }
  function getAll(){
    $res = $this->cat_generos_model->getAll();
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
}