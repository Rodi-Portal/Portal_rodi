<!DOCTYPE html>
<html>
<head>
    
    <meta charset="UTF-8">
    <style>
    body{font-family: Arial, Helvetica, sans-serif;}
    .div_fecha{text-align: right; padding-top: 20px;}
    .justificado{text-align: justify;}
    .centrado{text-align: center;}
    .subrayado{text-decoration: underline;}
    .imagen { width: 600px; height: 750px; }
    .firma { width: 200px; height: 75x; }
    .padding{ padding: 40px;}
    .f-12{ font-size: 12px;}
    .margen_top{padding-top: 20px;}
    .linea{ padding-top: 0px; margin-top: 0px;}
    .table{width: 100%; max-width: 100%; background-color: transparent; border-collapse: collapse; border-spacing: 0;}
    .carta{
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }
    .titulo_seccion{
        background-color: #5d7ca4;
        color: white;
    }
    th, td{padding: 7px; border: 1px solid #ddd;}
    td{text-align: left;height: 10px; vertical-align: bottom;font-size: 12px; text-align: center;}
    tr:nth-child(even) {background-color: #f2f2f2;}
    h4{margin-top: 5px; margin-bottom: 5px;}


    </style>
</head>
<body>

    <div class="div_fecha">
        <p class=""><b>Guadalajara, Jalisco a <?php echo $fecha_medico; ?></b></p><br>
    </div>

    <h2 class="centrado">EXAMEN MÉDICO LABORAL</h2>

    <p>A quien corresponda:</p>

    <p class="centrado">El que suscribe <?php echo $area->responsable ?> acreditado para ejercer la profesión<br> con cédula profesional número 664579.</p><br>

    <p class="centrado"><b>CERTIFICA A:</b></p>

    <p class="centrado"><b><?php echo strtoupper($info->candidato) ?></b></p>

    <p class="centrado"><?php echo $info->genero ?> de <b><?php echo $info->edad ?></b> años como persona que <?php echo $info->descripcion ?>.</p><br>

    <p class="centrado subrayado"><b>Conclusión</b></p>
    <p class="centrado"><b><?php echo $info->conclusion ?>.</b></p>

    <p class="centrado">Agradeciendo de antemano la atención, se extiende el presente certificado para los fines que convengan al interesado.</p><br>

    <?php 
    $firma = base_url().'img/'.$area->firma;
     ?>

    <div class="centrado">
        <img class="firma" src="<?php echo $firma ?>">
        <p class="linea">___________________________________</p>
    </div> 

    <p class="centrado"><b>Atentamente</b></p>
    <p class="centrado"><?php echo $area->responsable ?></p>
    <p class="centrado">Cédula profesional número <?php echo $area->cedula ?></p>



    <pagebreak>
    <div class="div_fecha">
        <p class=""><b>Guadalajara, Jalisco a <?php echo $fecha_medico; ?></b></p><br>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Ficha Identificación</h4>
        </div>
            <table class="table">
              <tr>
                <td colspan="2">
                    <p>Nombre: <b><?php echo strtoupper($info->candidato) ?></b></p>
                </td>
                <td>
                    <p>Edad: <b><?php echo $info->edad?></b></p>
                </td>
                <td>
                    <p>Género: <b><?php echo $info->genero ?></b></p>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                    <p>Fecha de nacimiento: <b><?php echo $info->fecha_nacimiento ?></b></p>
                </td>
                <td colspan="2">
                    <p>Telefono de emergencia: <b><?php echo $info->telefono_emergencia ?></b></p>
                </td>
              </tr>
              <tr>
                  <td colspan="2">
                      <p> Avisar a: <b><?php echo $info->avisar_a ?></b></p>
                  </td>
                  <td>
                      <p> Estado civil: <b><?php echo $info->estado_civil; ?></b></p>
                  </td>
                  <td>
                      <p> Escolaridad: <b>
                        <?php

                        switch($info->id_grado_estudio) {
                                case 1:
                                echo 'Primaria';
                                break;
                                case 2:
                                echo 'Secundaria';
                                break;
                                case 3:
                                echo 'Bachiller';
                                break;
                                case 4:
                                echo 'Licenciatura';
                                break;
                                case 5:
                                echo 'Maestría';
                                break;
                                case 6:
                                echo 'Carrera técnica';
                                break;
                                case 7:
                                echo 'Analfabeta';
                                break;
                                case 8:
                                echo 'Autodidacta';
                                break;
                                case 9:
                                echo 'Preescolar';
                                break;

                                default:
                                echo 'Error: No se encontro el grado de estudio.';
                            } 
                        ?>   
                        </b></p>
                  </td>
              </tr>

            </table>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Antecedentes Heredo-Familiares</h4>
        </div>
            <table class="table">
                <tr>
                    <td>
                       <p>Diabetes: <b><?php echo $info->diabetes ?></b></p>
                    </td>
                    <td>
                       <p>Hipertensión: <b><?php echo $info->hipertension ?></b></p>
                    </td>
                    <td>
                        <p>Cáncer: <b><?php echo $info->cancer ?></b></p>
                    </td>
                    <td>
                        <p>Cardiopatias: <b><?php echo $info->cardiopatias ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Enfermedades pulmonares: <b><?php echo $info->pulmonares ?></b></p>
                    </td>
                    <td>
                        <p>Enfermedades Renales: <b><?php echo $info->renales ?></b></p>
                    </td>
                    <td colspan="2">
                        <p>Enfermades psiquiátricas: <b><?php echo $info->psiquiatricas ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Tipo de sangre: <b><?php echo $info->tipo_sangre ?></b></p>
                    </td>
                    <td colspan="3">
                        <p>Enfermades: <b><?php echo $info->cuales_antecedentes_familiares ?></b></p>
                    </td>
                </tr>
            </table>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Antecedentes No Patológicos</h4>
        </div>
            <table class="table">
                <tr>
                   <td colspan="2">
                       <p>Tabaco: <b><?php echo $info->tabaco ?></b></p>
                   </td>
                   <td colspan="2">
                       <p>Exposición al tabaco: <b>
                        <?php
                        if($info->tabaco_frecuencia != 'N/A'){
                            $unidad;
                            $info->tabaco_cantidad > 1? $unidad = 'unidades':$unidad = 'unidad';
                            $resultadoStr = $info->tabaco_cantidad . " " . $unidad . " " . strtolower ($info->tabaco_frecuencia);
                            echo $resultadoStr;
                        }else
                            echo 'N/A';

                        ?></b></p>
                   </td>
                </tr>
                <tr>
                   <td colspan="2">
                       <p>Alcohol: <b><?php echo $info->alcohol ?></b></p>
                   </td>
                   <td colspan="2">
                       <p>Exposición al alcohol: <b>
                        <?php
                        if($info->alcohol_frecuencia != 'N/A'){
                            $unidad;
                            $info->alcohol_cantidad > 1? $unidad = 'unidades':$unidad = 'unidad';
                            $resultadoStr = $info->alcohol_cantidad . " " . $unidad . " " . strtolower ($info->alcohol_frecuencia);
                            echo $resultadoStr;
                        }else
                            echo 'N/A';

                        ?></b></p>
                   </td>
                </tr>
                <tr>
                    <td>
                        <p>Dogras: <b><?php echo $info->droga ?></b></p>
                    </td>
                    <td>
                        <p>Tipo de droga: <b><?php echo $info->droga_tipo ?></b></p>
                    </td>
                    <td>
                        <p>Deporte: <b><?php echo $info->deporte ?></b></p>
                    </td>
                    <td>
                        <p>Cuál: <b><?php echo $info->deporte_cual ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p>Alimentacion: <b><?php echo $info->alimentacion ?></b></p>
                    </td>
                </tr>
            </table>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Antecedentes Patológicos Personales</h4>
        </div>
            <table class="table">
                <tr>
                    <td>
                        <p>Quirúrgicos: <b><?php echo $info->quirurgicos ?></b></p>
                    </td>
                    <td>
                        <p>¿Hace cuánto?: <b><?php echo $info->quirurgicos_hace_cuanto ?></b></p>
                    </td>
                    <td>
                        <p>Descripción: <b><?php echo $info->quirurgicos_cual ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Internamientos: <b><?php echo $info->internamientos ?></b></p>
                    </td>
                    <td>
                        <p>¿Hace cuánto?: <b><?php echo $info->internamientos_hace_cuanto ?></b></p>
                    </td>
                    <td>
                        <p>Descripción: <b><?php echo $info->internamientos_porque ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Transfuciones: <b><?php echo $info->transfusiones ?></b></p>
                    </td>
                    <td>
                        <p>¿Hace cuánto?: <b><?php echo $info->transfusiones_hace_cuanto ?></b></p>
                    </td>
                    <td>
                        <p>Descripción: <b><?php echo $info->transfusiones_porque ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Fracturas: <b><?php echo $info->fracturas ?></b></p>
                    </td>
                    <td>
                        <p>Luxaciones: <b><?php echo $info->luxaciones ?></b></p>
                    </td>
                    <td>
                        <p>Esguinces: <b><?php echo $info->esguinces ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Traumatismo: <b><?php echo $info->traumatismo ?></b></p>
                    </td>
                    <td>
                        <p>Hernias: <b><?php echo $info->hernia ?></b></p>
                    </td>
                    <td>
                        <p>Lesiones en columna: <b><?php echo $info->lesiones_columna ?></b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Alergias: <b><?php echo $info->alergias ?></b></p>
                    </td>
                    <td colspan="2">
                        <p>Alergias a que: <b><?php echo $info->alergias_cual ?></b></p>
                    </td>
                </tr>
            </table>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Chequeo General</h4>
        </div>
            <table class="table">
                <tr>
                   <td>
                       <p>Estatura: <b><?php echo $info->estatura ?> mts.</b></p>
                   </td>
                   <td>
                       <p>Peso: <b><?php echo $info->peso ?> kg.</b></p>
                   </td>
                   <td>
                       <p>IMC: <b><?php echo $info->imc ?> %</b></p>
                   </td>
                   <td>
                       <p>Grasa Muscular: <b><?php echo $info->grasa ?> %</b></p>
                   </td>
                </tr>
                <tr>   
                   <td>
                       <p>Musculo: <b><?php echo $info->musculo ?> %</b></p>
                   </td>
                   <td>
                       <p>Calorias: <b><?php echo $info->calorias ?> cal.</b></p>
                   </td>
                   <td>
                       <p>Edad Met: <b><?php echo $info->edad_metabolica ?></b></p>
                   </td>
                   <td>
                       <p>Grasa Viceral: <b><?php echo $info->grasa_visceral ?> %</b></p>
                   </td>
                </tr>
                <tr>
                   <td>
                       <p>Presion: <b><?php echo $info->presion ?> mm/Hg</b></p>
                   </td>
                   <td>
                       <p>F.C.: <b><?php echo $info->frecuencia_cardiaca ?></b></p>
                   </td>
                   <td>
                       <p>Glucosa: <b><?php echo $glucosa = ($info->glucosa != 0)? $info->glucosa.' mg/dl' : 'Desconocida'; ?> </b></p>
                   </td>
                </tr>
            </table>
    </div>
    <div class="carta">
        <div class="titulo_seccion centrado">
            <h4>Visión</h4>
        </div>
            <table class="table">
                <tr>
                   <td>
                       <p>Ojo derecho: <b><?php echo $info->vision_derecha ?></b></p>
                   </td>
                   <td>
                       <p>Ojo izquierdo: <b><?php echo $info->vision_izquierda ?></b></p>
                   </td>
                   <td>
                       <p>Colores: <b><?php echo $info->vision_color ?></b></p>
                   </td>
                   <td>
                       <p>Usa lentes: <b><?php echo $info->lentes ?></b></p>
                   </td>
                </tr>
            </table>
    </div>

    
    
    
</body>
</html>