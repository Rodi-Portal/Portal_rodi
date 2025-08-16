<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }

    public function getDatosAntidoping()
    {
        $salida             = "";
        $data['sustancias'] = $this->configuracion_model->getSustanciasAntidoping();
        $data['paquetes']   = $this->configuracion_model->getPaquetesAntidoping();
        if ($data['paquetes']) {
            $salida .= '<div><p style="text-align: center;">Elige la opción para el Antidoping</p><br></div>';
            $salida .= '<div class="row">';
            $salida .= '<div class="col-md-6" style="border-right: 1px solid gray;">';
            $salida .= '<p style="text-align: center;">Por paquete: </p><br>';
            foreach ($data['paquetes'] as $paq) {
                $s          = "";
                $sustancias = explode(',', $paq->sustancias);
                for ($i = 0; $i < count($sustancias); $i++) {
                    foreach ($data['sustancias'] as $item) {
                        $s .= ($sustancias[$i] == $item->id) ? $item->abreviatura . "," : "";
                    }
                }
                $salida .= '<label class="contenedor_check">' . $paq->nombre . ' <small>(' . substr($s, 0, -1) . ')</small>
	                                <input type="checkbox" class="clase_paquete" name="paq' . $paq->id . '" id="paq' . $paq->id . '" value="' . $paq->id . '">
	                                <span class="checkmark"></span>
	                            </label>';

            }
            $sustancia = "";
            $cont      = 1;
            $salida .= '</div>';
            $salida .= '<div class="col-md-6">';
            $salida .= '<p style="text-align: center;">Por parámetro: </p><br>';
            foreach ($data['sustancias'] as $s) {
                $salida .= '<div style="float: left;padding-right: 10px;width: 240px;">';
                $salida .= '<label class="contenedor_check">' . $s->abreviatura . ' (' . $s->descripcion . ')
	                                <input type="checkbox" class="clase_parametro" name="sust' . $s->id . '[]" id="sust' . $s->id . '" value="' . $s->id . '">
	                                <span class="checkmark"></span>
	                            </label>';
                $salida .= '</div>';
                $salida .= ($cont % 4 == 0) ? "<br>" : "";
                $cont++;
            }
            $salida .= '</div>';
            $salida .= '</div>';
            $salida .= '<script>
			$("input[id^=sust]").click(function(){
				$(".clase_paquete").each(function(i,item){
					$(item).prop("checked",false);
		    	});
			});
			$("input[id^=paq]").click(function(){
				$(".clase_parametro").each(function(i,item){
					$(item).prop("checked",false);
		    	});
		    	$(".clase_paquete").each(function(i,item){
					$(item).prop("checked",false);
		    	});
		    	$(this).prop("checked",true);
			});
			</script>';
        }
        echo $salida;
    }
    public function getDatosPsicometrico()
    {
        $puesto           = $_POST['puesto'];
        $salida           = "";
        $data['pruebas']  = $this->configuracion_model->getPruebasPsicometricas();
        $data['baterias'] = $this->configuracion_model->getBateriaPsicometrica($puesto);
        if ($data['baterias']) {
            $salida .= '<div><p style="text-align: center;">Elige la opción para la Psicometría</p><br></div>';
            $salida .= '<div class="row">';
            $salida .= '<div class="col-md-4" style="border-right: 1px solid gray;">';
            $salida .= '<p style="text-align: center;">Para el puesto elegido se realizarán las siguientes pruebas: </p><br>';
            foreach ($data['baterias'] as $bat) {
                $pr      = "";
                $pruebas = explode(',', $bat->pruebas);
                for ($i = 0; $i < count($pruebas); $i++) {
                    foreach ($data['pruebas'] as $item) {
                        $pr .= ($pruebas[$i] == $item->id) ? $item->abreviatura . "," : "";
                    }
                }
                $salida .= '<label class="contenedor_check">' . $bat->nombre . ' <small>(' . substr($pr, 0, -1) . ')</small>
	                                <input type="checkbox" class="clase_bateria" name="bat' . $bat->id . '" id="bat' . $bat->id . '" value="' . $bat->id . '" checked>
	                                <span class="checkmark"></span>
	                            </label>';

            }
            $cont = 1;
            $salida .= '</div>';
            $salida .= '<div class="col-md-8">';
            $salida .= '<p style="text-align: center;">Por prueba: </p><br>';
            foreach ($data['pruebas'] as $p) {
                $salida .= '<div style="float: left;padding-right: 10px;width: 340px;">';
                $salida .= '<label class="contenedor_check">' . $p->abreviatura . ' (' . $p->descripcion . ')
	                                <input type="checkbox" class="clase_prueba" name="pru' . $p->id . '[]" id="pru' . $p->id . '" value="' . $p->id . '">
	                                <span class="checkmark"></span>
	                            </label>';
                $salida .= '</div>';
                $salida .= ($cont % 4 == 0) ? "<br>" : "";
                $cont++;
            }
            $salida .= '</div>';
            $salida .= '</div>';
            $salida .= '<script>
			$("input[id^=pru]").click(function(){
				$(".clase_bateria").each(function(i,item){
					$(item).prop("checked",false);
		    	});
			});
			$("input[id^=bat]").click(function(){
				$(".clase_prueba").each(function(i,item){
					$(item).prop("checked",false);
		    	});
			});
			</script>';
        }
        echo $salida;
    }
    public function getDatosBuroCredito()
    {
        $salida        = "";
        $data['tipos'] = $this->configuracion_model->getDatosBuroCredito();
        if ($data['tipos']) {
            $salida .= '<div><p style="text-align: center;">Elige la opción para el Buró de Crédito</p><br></div>';
            $salida .= '<div class="row">';
            $salida .= '<div class="col-md-6 offset-md-4">';
            //$salida .= '<p style="text-align: center;">Por paquete: </p><br>';
            foreach ($data['tipos'] as $t) {

                $salida .= '<label class="contenedor_check">' . $t->nombre . '
	                                <input type="checkbox" class="clase_buro" name="cred' . $t->id . '" id="cred' . $t->id . '" value="' . $t->id . '">
	                                <span class="checkmark"></span>
	                            </label>';

            }
            $salida .= '</div>';
            $salida .= '</div>';
            $salida .= '<script>

			$("input[id^=cred]").click(function(){
				$("input:checkbox[id^=cred]:checked").each(function(i,item){
					$(item).prop("checked",false);
		    	});
		    	$(this).prop("checked",true);
			});
			</script>';
        }
        echo $salida;
    }

    public function save()
    {
        if (! $this->input->is_ajax_request()) {
            echo json_encode(['ok' => false, 'error' => 'Método no permitido']);return;
        }

        $userId   = (int) $this->session->userdata('id');
        $portalId = (int) $this->session->userdata('idPortal');
        $payload  = json_decode($this->input->post('payload', true), true);

        if (! $userId || ! $portalId || ! $payload || empty($payload['table_key'])) {
            echo json_encode(['ok' => false, 'error' => 'Parámetros inválidos']);return;
        }

        $modulo       = trim($payload['table_key']);
        $visibleNames = $payload['settings']['visible_names'] ?? null;

        if (! is_array($visibleNames)) {
            echo json_encode(['ok' => false, 'error' => 'Se esperaba un arreglo de nombres (visible_names)']);return;
        }

        // Sanitiza: strings y únicos, preservando orden
        $clean = [];
        foreach ($visibleNames as $n) {
            $n = trim((string) $n);
            if ($n !== '' && ! in_array($n, $clean, true)) {
                $clean[] = $n;
            }

        }

        try {
            // id_cliente = NULL (global)
            $ok = $this->comunicacion_model->guardarConfiguracion(
                $userId, null, $portalId, $modulo, $clean
            );

            if ($ok === true) {
                $resp = ['ok' => true, 'msg' => 'Preferencias guardadas.'];
                if ($this->security->get_csrf_hash()) {
                    $resp['csrf'] = $this->security->get_csrf_hash();
                }

                echo json_encode($resp);return;
            }

            echo json_encode(['ok' => false, 'error' => 'No se pudo guardar la configuración']);return;

        } catch (\Throwable $e) {
            $dbErr = $this->db->error();
            log_message('error', 'Guardar config EXCEPTION: ' . $e->getMessage());
            log_message('error', 'DB error: ' . json_encode($dbErr));
            log_message('error', 'Last query: ' . $this->db->last_query());

            $msg = $e->getMessage();
            if (! empty($dbErr['message'])) {
                $msg .= ' | DB: ' . $dbErr['message'];
            }

            echo json_encode(['ok' => false, 'error' => $msg]);return;
        }
    }

}
