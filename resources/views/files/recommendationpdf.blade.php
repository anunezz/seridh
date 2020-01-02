<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>

    <?php
    set_time_limit(0);
    ini_set("memory_limit",'2024M'); // ini_set('memory_limit', '2024M'); // or you could use 1G
    ini_set('max_execution_time', 0);
    ?>

    @if(count($results) > 1)
        <title>Recomendaciones</title>
    @else
        <title>Recomendación</title>
    @endif

    <style>
        *{
            font-family: "Monserrat", cursive;
        }
        @page { margin: 130px 50px 45px 50px }
        #header { position: fixed; left: 0px; top: -105px; right: 0px; height: 150px;  text-align: center; }
        #footer { position: fixed; left: 0px; bottom: -45px; right: 0px; height: 50px;  }
        #footer .page:after {
            content: counter(page);
        }
    </style>
<body>

<div id="header">
    <div style="width: 100%;">

        <img src="img/public/logos/relacionesExteriores.JPG" style="margin: 4px 0px 0px -8px;  display: block; width: 280px; height: 50px;" >
        <img src="img/public/logos/seridh.png" style=" margin: 10px 0px 0px 180px; display: block; width: 220px; height: 65px;">
    </div>
    <div style=" margin-top: -18px !important; width: 100%; font-size: 15px; text-align: center;">
        <h4>Descarga personalizada de recomendaciones</h4>
    </div>
</div>

<div id="footer">
    <p class="page" style="text-align: center;"></p>
</div>
<div id="content">

    <?php $increment = 0; ?>
    @foreach($results as $value)

        <?php
        //Derechos Humanos
        $max = max([count($value->right),count($value->topic)]);
        $firsTable = [];
        $i = 0;

        foreach($value->right as $valueRight){
            $firsTable[$i]['nameRigth']= $valueRight['name'];
            $firsTable[$i]['dataRight']= $valueRight['data'];
            $i++;
        }

        //Temas
        $i = 0;
        foreach($value->topic as $vTopic){
            $firsTable[$i]['nameTopic'] = $vTopic->name;
            $firsTable[$i]['dataSubtopic'] = $vTopic->subtop;
            $i++;
        }

        //Población
        $i = 0;
        $population = explode(',',$value->implode_population);
        for($i=0; $i < count($population); $i++){
            $firsTable[$i]['namePopulation'] = $population[$i];
        }
        ?>

        <div>
            <?php  $increment = $increment +1; ?>

            <table cellpadding="1" cellspacing="1" style="bottom: 0; right: 0; text-align:left;">
                <tr>
                    <td colspan="5">

                        <div style="font-size:12px;">
                            <h4>Recomendación</h4>
                        </div>

                        <div style="font-size:12px; !important;">
                            <?php echo html_entity_decode($value->recommendation); ?>
                        </div>

                    </td>
                </tr>

                <tr style="font-size:12px; text-aling: left;">
                    <td valign="top"> <!--<h4>Año y Entidad emisora</h4>--> </td>
                    <td valign="top"> <h4>Derecho</h4> </td>
                    <td valign="top"> <h4>Tema</h4> </td>
                    <td valign="top"> <h4>Subtema</h4> </td>
                    <td valign="top"> <h4>Población</h4> </td>
                </tr>


                @for($i=0; $i < $max; $i++)
                    <tr style="font-size:11px;">
                        <td colspan="1" WIDTH="55" valign="top">
                            @if($i === 0)
                                {{ $value->date }} <br>
                                {{ $value->cat_entity_id  }}
                            @endif
                        </td>

                        <td colspan="1" WIDTH="100" valign="top">
                            {{ $firsTable[$i]['nameRigth'] = (isset($firsTable[$i]['nameRigth']))? $firsTable[$i]['nameRigth']: '' }}
                        </td>

                        <td colspan="1" WIDTH="100" valign="top">
                            {{ $firsTable[$i]['nameTopic'] = (isset($firsTable[$i]['nameTopic']))? $firsTable[$i]['nameTopic']: '' }}
                        </td>

                        <td colspan="1" WIDTH="100" valign="top">
                            <?php
                            $firsTable[$i]['dataSubtopic'] = (isset($firsTable[$i]['dataSubtopic']))? $firsTable[$i]['dataSubtopic']: '';

                            if($firsTable[$i]['dataSubtopic'] !== ''){
                                echo "<ul style='list-style:none; margin:0; padding:0;'>";

                                foreach($firsTable[$i]['dataSubtopic'] as $vSubtop){
                                    echo " <li>".$vSubtop->name  ."</li>";
                                }
                                echo "</ul>";

                            }


                            ?>

                        </td>

                        <td colspan="1" WIDTH="100" valign="top">
                            {{ $firsTable[$i]['namePopulation'] = (isset($firsTable[$i]['namePopulation']))? $firsTable[$i]['namePopulation']: '' }}
                        </td>

                    </tr>
                @endfor

                <tr style="font-size:12px; text-aling: left;">
                    <td colspan="2" width="100" valign="top"> <h4>ODS</h4> </td>
                    <td colspan="2" width="100" valign="top"> <h4>Acción solicitada</h4> </td>
                    <td colspan="1" width="100" valign="top"> <h4>Poder de gobierno</h4> </td>
                </tr>

                <?php

                //Derechos Humanos
                $maxS = max([count($value->Ods),count($value->topic)]);
                $secondTable = [];
                $i = 0;

                //Ods
                foreach($value->Ods as $valueOds){
                    $secondTable[$i]['nameOds']= $valueOds['name'];
                    // $secondTable[$i]['dataRight']= $valueOds['data'];
                    $i++;
                }
                //Accion Solicitada
                $i = 0;
                foreach(explode("|",$value->implode_action) as $valueActions){
                    $secondTable[$i]['nameActions']= $valueActions;
                    $i++;
                }

                //Poder de gobierno
                $JSOGobPower = explode(",",$value->implode_power);
                $i = 0;
                foreach($JSOGobPower as $ValuePower){
                    $secondTable[$i]['nameGobPower'] = $ValuePower;
                    $i++;
                }

                ?>
                @for($i=0; $i < count($secondTable); $i++)
                    <tr style="font-size:11px;">
                        <td colspan="2" width="100" valign="top">
                            {{ $secondTable[$i]['nameOds'] = (isset($secondTable[$i]['nameOds']))? $secondTable[$i]['nameOds']: '' }}
                        </td>
                        <td colspan="2" width="100" valign="top">
                            {{ $secondTable[$i]['nameActions'] = (isset($secondTable[$i]['nameActions']))? $secondTable[$i]['nameActions']: '' }}

                        </td>
                        <td colspan="1" width="100" valign="top">
                            {{ $secondTable[$i]['nameGobPower'] = (isset($secondTable[$i]['nameGobPower']))? $secondTable[$i]['nameGobPower']: '' }}
                        </td>

                    </tr>
                @endfor

            </table>

            <br> <br>

            @if(count($value->reportedaction) > 0)

                <div class="dashed" ></div>

                <div style="width: 100%; font-size: 15px; text-align: center;">
                    <h4>Acciones reportadas para la recomendación {{ $increment  }}</h4>
                </div>



                <?php $in = 0; ?>

                @foreach($value->reportedaction as $valueReportedaction)




                    <table cellpadding="1" cellspacing="1">
                        <tr style="font-size:12px; !important">
                            <td colspan="3">
                                <h4>Acción <?php  echo $in = $in + 1; ?></h4>   <br>
                                <div style="font-size:12px; !important;">
                                    <?php echo html_entity_decode( $valueReportedaction->description); ?>
                                </div>
                            </td>
                        </tr>


                        <tr style="font-size:12px;">
                            <td colspan="1"width="150"> <h4>Fecha reportada</h4> </td>
                            <td colspan="1" width="150"> <h4>Autoridad que reporto</h4></td>
                            <td colspan="1" width="150" valign="top"> <h4>Tipo de acción reportada</h4> </td>
                        </tr>

                        <tr style="font-size:10px;">
                            <td colspan="1"> {{$valueReportedaction->date}}  </td>
                            <td colspan="1" width="150" valign="top">
                                @foreach($valueReportedaction->attendig as $vattenting)
                                    {{ $vattenting->name}}
                                @endforeach
                            </td>
                            <td colspan="1" width="150" valign="top" style="text-aling: left;">
                                @foreach($valueReportedaction->action as $vaction )
                                    {{ $vaction->name }}
                                @endforeach
                            </td>

                        </tr>
                    </table>
                @endforeach

            @endif

            <hr>
            <br>
        </div>
    @endforeach
</div>
</body>
</html>

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 730, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script>
