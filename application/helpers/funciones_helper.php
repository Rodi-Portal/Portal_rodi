<?php
defined('BASEPATH') or exit('No direct script access allowed');

function fecha_ingles_bd($date)
{
    $aux   = explode('/', $date);
    $fecha = $aux[2] . '-' . $aux[0] . '-' . $aux[1];
    return $fecha;
}
function fecha_espanol_bd($date)
{
    $aux   = explode('/', $date);
    $fecha = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
    return $fecha;
}
function fecha_espanol_frontend($date)
{
    $aux   = explode('-', $date);
    $fecha = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
    return $fecha;
}
function fecha_ingles_usuario($date)
{
    $aux   = explode('-', $date);
    $fecha = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
    return $fecha;
}
function fecha_sinhora_espanol_bd($date)
{
    $f     = explode(' ', $date);
    $aux   = explode('-', $f[0]);
    $fecha = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
    return $fecha;
}
function fecha_hora_espanol_bd($date)
{
    $time  = explode(' ', $date);
    $aux   = explode('/', $time[0]);
    $fecha = $aux[2] . '-' . $aux[1] . '-' . $aux[0] . ' ' . $time[1] . ':00';
    return $fecha;
}
function fecha_hora_ingles_front($date)
{
    $time  = explode(' ', $date);
    $aux   = explode('-', $time[0]);
    $fecha = $aux[1] . '/' . $aux[2] . '/' . $aux[0] . ' ' . $time[1] . ':00';
    return $fecha;
}
function fecha_h_i_ingles($date)
{
    $time  = explode(' ', $date);
    $aux   = explode('-', $time[0]);
    $aux2  = explode(':', $time[1]);
    $fecha = $aux[1] . '/' . $aux[2] . '/' . $aux[0] . ' ' . $aux2[0] . ':' . $aux2[1];
    return $fecha;
}
function fecha_sinhora_ingles_front($date)
{
    $f     = explode(' ', $date);
    $aux   = explode('-', $f[0]);
    $fecha = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
    return $fecha;
}
function calculaEdad($fechanacimiento)
{
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia        = date("Y") - $ano;
    $mes_diferencia        = date("m") - $mes;
    $dia_diferencia        = date("d") - $dia;
    if ($mes_diferencia < 0 || ($mes_diferencia == 0 && $dia_diferencia < 0 || $mes_diferencia < 0)) {
        $ano_diferencia--;
    }

    return $ano_diferencia;
}
function formatoFecha($f)
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
function fecha_sinhora_espanol_front($date)
{
    $f     = explode(' ', $date);
    $aux   = explode('-', $f[0]);
    $fecha = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
    return $fecha;
}
function formatoFechaEspanol($f)
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
function formatoFechaEspanolPDF($f)
{
    date_default_timezone_set('America/Mexico_City');
    $numeroDia = date('d', strtotime($f));
    $mes       = date('F', strtotime($f));
    $anio      = date('Y', strtotime($f));
    $meses_ES  = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    $meses_EN  = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

    return $numeroDia . " de " . $nombreMes . " de " . $anio;
}
function formatoFechaDescripcion($f)
{
    $numeroDia = date('d', strtotime($f));
    $dia       = date('l', strtotime($f));
    $mes       = date('F', strtotime($f));
    $anio      = date('Y', strtotime($f));
    $dias_ES   = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
    $dias_EN   = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES  = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    $meses_EN  = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $nombreMes = str_replace($meses_ES, $meses_EN, $mes);

    $f_alta = $nombreMes . " " . $numeroDia . ", " . $anio;
    return $f_alta;
}
function generarPassword()
{
    //Se define una cadena de caractares.
    //Os recomiendo desordenar las minúsculas, mayúsculas y números para mejorar la probabilidad.
    $cadena         = "A1BCDEFGHI2JKLMNO3PQRST4UV5WXYZabc6defgh7ijk8lmn9opqr0stuvwxyz";
    $cadenaSimbolos = "!$*#&?";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena   = strlen($cadena);
    $longitudSimbolos = strlen($cadenaSimbolos);
    //Definimos la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, puedes poner la longitud que necesites
    //Se debe tener en cuenta que cuanto más larga sea más segura será.
    $longitudPass = 10;

    //Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
    for ($i = 1; $i <= $longitudPass; $i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos = rand(0, $longitudCadena - 1);

        //Vamos formando la contraseña con cada carácter aleatorio.
        $pass .= substr($cadena, $pos, 1);
    }

    for ($i = 1; $i <= 2; $i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos = rand(0, $longitudSimbolos - 1);

        //Vamos formando la contraseña con cada carácter aleatorio.
        $pass .= substr($cadenaSimbolos, $pos, 1);
    }
    echo $pass;

}
//* Formato fecha en texto
if (! function_exists('fechaTexto')) {
    /**
     * Formatea una fecha en español o inglés.
     * Mantiene la salida actual:
     *  - ingles:   "Month dd, YYYY"
     *  - espanol:  "dd de Mes de YYYY"
     *
     * @param mixed  $f       string "Y-m-d" o "Y-m-d H:i:s", timestamp, DateTime...
     * @param string $idioma  'espanol' | 'ingles'
     * @return string
     */
    function fechaTexto($f, $idioma)
    {
        // Guardas tempranas (evita strtotime(NULL) / valores inválidos)
        if ($f === null) {
            return '';
        }

        if ($f === '0000-00-00' || $f === '0000-00-00 00:00:00') {
            return '';
        }

        // Resolver timestamp una sola vez
        if ($f instanceof DateTimeInterface) {
            $ts = $f->getTimestamp();
        } else {
            $s = trim((string) $f);
            if ($s === '') {
                return '';
            }

            if (ctype_digit($s)) {
                // si mandan timestamp en segundos como string/entero
                $ts = (int) $s;
            } else {
                $ts = strtotime($s);
                if ($ts === false) {
                    return '';
                }

            }
        }

        // Partes de fecha (en inglés por defecto con date())
        $numeroDia = date('d', $ts);
        $dia       = date('l', $ts);
        $mes       = date('F', $ts);
        $anio      = date('Y', $ts);

        // Tablas de traducción (por compatibilidad con tu función original)
        $dias_ES  = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
        $dias_EN  = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $meses_ES = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $meses_EN = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        // (No usas el día de la semana en el resultado, pero conservo la línea por compatibilidad)
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);

        if ($idioma === 'ingles') {
            // 'mes' ya viene en inglés con date('F'), se mantiene la lógica original
            $nombreMes = str_replace($meses_ES, $meses_EN, $mes);
            return $nombreMes . " " . $numeroDia . ", " . $anio;
        }

        // español por defecto
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return $numeroDia . " de " . $nombreMes . " de " . $anio;
    }
}

//* Validar fecha (sin hora) en calendario en espanol
function validar_fecha_espanol($fecha)
{
    $valores = explode('/', $fecha);
    if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
        return true;
    }
    return false;
}
