<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentacion extends CI_Controller{

	function __construct(){
		parent::__construct();
    $this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getByCandidate(){
    $id_candidato = $this->input->post('id');
    $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
    if($seccion->id_seccion_verificacion_docs != 57){
      $res = $this->documentacion_model->getByCandidate($this->input->post('id'));
      if($res != null){
        echo json_encode($res);
      }
      else{
        echo $res = 0;
      }
    }
    if($seccion->id_seccion_verificacion_docs == 57){
      $res = $this->candidato_model->getById($this->input->post('id'));
      if($res != null){
        echo json_encode($res);
      }
      else{
        echo $res = 0;
      }
    }
  }
  function update(){
    $id_candidato = $this->input->post('id_candidato');
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $this->form_validation->set_rules($campo->name,$campo->backend_label,$campo->backend_rule);

        $this->form_validation->set_message('required','El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        if ($this->form_validation->run() == FALSE) {
          $fail++;
          break;
        } 
      }
      if($fail > 0){
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }
      else{
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        
        $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
        if($seccion->id_seccion_verificacion_docs != 57){
          $hayId = $this->documentacion_model->countByIdCandidato($id_candidato);
          if($hayId == 0){
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            $this->documentacion_model->add($creacion);
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->documentacion_model->edit($edicion, $id_candidato);
            }
          }
          else{
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->documentacion_model->edit($edicion, $id_candidato);
            }
          }
        }
        if($seccion->id_seccion_verificacion_docs == 57){
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_model->edit($edicion, $id_candidato);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'Registros de documentacion actualizados correctamente'
        );
      }
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Error en el formulario'
      );
    }
    echo json_encode($msj);
  }

  function subirArchivo(){
    if (isset($_FILES["archivo"]["name"])) {
      $date = date('Y-m-d H:i:s');
      $id_candidato = $this->input->post('id_candidato');
      $id_archivo = $this->input->post('id_archivo');
      $tipoArchivo = $this->input->post('tipoArchivo');
      $id_usuario = $this->session->userdata('id');
      $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
      $cadena = substr(md5(time()), 0, 16);
      $nombre_archivo = $cadena.".".$extension;

      if($tipoArchivo == 'psicometrico'){
        $carpeta = './_psicometria/';
        //$tipoDocumento = NULL;
        $tablaBD = 'psicometrico';
        $msj = 'La psicometria se ha subido correctamente';
      }
      if($tipoArchivo == 'beca'){
        $carpeta = './_beca/';
        //$tipoDocumento = NULL;
        $tablaBD = 'beca';
        $msj = 'El estudio de la solicitud de beca se ha subido correctamente';
      }
      $config['upload_path'] = $carpeta;  
      $config['allowed_types'] = 'pdf';
      $config['overwrite'] = TRUE;
      $config['file_name'] = $nombre_archivo;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      // File upload
      if($this->upload->do_upload('archivo')){
        $archivoAnterior = $this->documentacion_model->getArchivo($id_candidato, $tablaBD);
        if(!empty($archivoAnterior->archivo)){
          unlink($carpeta.$archivoAnterior->archivo);
        }
        $this->documentacion_model->eliminarArchivo($id_candidato, $tablaBD);
        $doc = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_candidato' => $id_candidato,
          'archivo' => $nombre_archivo
        );
        $this->documentacion_model->subirArchivo($doc, $tablaBD);
        $msj = array(
          'codigo' => 1,
          'msg' => $msj
        );
      }
      else{
        $msj = array(
          'codigo' => 0,
          'msg' => 'Error al subir el archivo'
        );
      }
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Elija un archivo válido para subir'
      );
    }
    echo json_encode($msj);
  }

  function subirArchivosCandidato(){
    if (isset($_FILES["archivos"]["name"])) {
      $date = date('Y-m-d H:i:s');
      $id_candidato = $this->input->post('id_candidato');
      //$id_archivo = $this->input->post('id_archivo');
      $id_tipo = $this->input->post('id_tipo');
      //$id_usuario = $this->session->userdata('id');
      $exito = 1;
      $countfiles = count($_FILES['archivos']['name']);
      for($i = 0; $i < $countfiles; $i++){
        $_FILES['archivo']['name'] = $_FILES['archivos']['name'][$i];
        $_FILES['archivo']['type'] = $_FILES['archivos']['type'][$i];
        $_FILES['archivo']['tmp_name'] = $_FILES['archivos']['tmp_name'][$i];
        $_FILES['archivo']['error'] = $_FILES['archivos']['error'][$i];
        $_FILES['archivo']['size'] = $_FILES['archivos']['size'][$i];
        $extension = pathinfo($_FILES['archivos']['name'][$i], PATHINFO_EXTENSION);
        $cadena = substr(md5(time()), 0, 16);
        $nombre_archivo = $cadena.".".$extension;
        $carpeta = './_docs/';
        $tablaBD = 'candidato_documento';
        $msj = 'File uploaded successfully';

        $config['upload_path'] = $carpeta;  
        $config['allowed_types'] = 'pdf|jpeg|jpg|png';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $nombre_archivo;
        $config['max_size'] = '2048'; // max_size in kb
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if($this->upload->do_upload('archivo')){
          $archivoAnterior = $this->documentacion_model->getFilesByType($id_tipo, $id_candidato, $tablaBD);
          if(!empty($archivoAnterior->archivo)){
            unlink($carpeta.$archivoAnterior->archivo);
          }
          $this->documentacion_model->deleteFileByType($id_tipo, $tablaBD, $id_candidato);
          $doc = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
            'id_tipo_documento' => $id_tipo,
            'archivo' => $nombre_archivo
          );
          $this->documentacion_model->subirArchivo($doc, $tablaBD);
        }
        else{
          $exito = 0;
        }
      }
      if($exito == 1){
        $msj = array(
          'codigo' => 1,
          'msg' => $msj
        );
      }else{
        $msj = array(
          'codigo' => 0,
          'msg' => "There's a problem uploading the file. The file must be 2MB or less and in PDF or image format."
        );
      }
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Choose a valid file to upload'
      );
    }
    echo json_encode($msj);
  }

  function getDocumentosRequeridosByCandidato(){
    $data['docs'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($this->input->post('id'));
    $salida = '<table class="table">';
    $salida .= '<thead>';
    $salida .= '<tr>';
    $salida .= '<th scope="col">Documento</th>';
    $salida .= '<th scope="col">Obligatorio</th>';
    $salida .= '<th scope="col">Solicitado al candidato</th>';
    $salida .= '</tr>';
    $salida .= '</thead>';
    $salida .= '<tbody>';
    if($data['docs']){
      foreach($data['docs'] as $doc){
        $obligatorio = ($doc->obligatorio == 1)? 'SI' : 'NO';
        $solicitado = ($doc->solicitado == 1)? 'SI' : 'NO';
        $salida .= '<tr><td>'.$doc->nombre_espanol.' <small>('.$doc->nombre_ingles.')</small></td>';
        $salida .= '<td>'.$obligatorio.'</td>';
        $salida .= '<td>'.$solicitado.'</td></tr>';
      }
    }else{
      $salida .= '<tr><td colspan="3">No se encontraron documentos requeridos para este candidato de acuerdo a su proceso</td></tr>';
    }
    $salida .= '</tbody>';
    $salida .= '</table>';
    echo $salida;
  }
}