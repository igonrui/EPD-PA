<!DOCTYPE html>
<?php

function sumTime($times) {
    //comprobacion por si es abandono
    foreach ($times as $time) {
        list($minutes, $seconds, $centiseconds) = explode(':', $time);
        $trimmed = trim($centiseconds);
        if ($minutes == 0 && $seconds == 0 && $trimmed == 0) {
            $totalTime = "99:99:99";
        }
    }
    //funcion normal para sumar tiempos, en caso de que no haya abandonado
    if (empty($totalTime)) {
        $all_centiseconds = 0;
        foreach ($times as $time) {
            list($minutes, $seconds, $centiseconds) = explode(':', $time);
            $trimmed = trim($centiseconds);
            $all_centiseconds += $minutes * 6000;
            $all_centiseconds += $seconds * 100;
            $all_centiseconds += $trimmed;
        }
        $total_seconds = floor($all_centiseconds / 100);
        $trimmed = $all_centiseconds % 100;
        $minutes = floor($total_seconds / 60);
        $seconds = $total_seconds % 60;
        $totalTime = $minutes . ":" . $seconds . ":" . $trimmed;
    }
    return $totalTime;
}

function minTime($times) {

    if (in_array("::", $times)) {
        /*
          if ($min["tiempo"] == "::") { */
        $min["tiempo"] = null;
        $min["vuelta"] = null;
    } else {
        $min["tiempo"] = min($times);
        $min["vuelta"] = array_search(min($times), $times);
    }
    return $min;
}
?>


<html>
    <body>		
        <?php
        if (isset($_POST['envio'])) {
            // Comprobamos que los campos obligatorios estan rellenos, creando un vector errores que iremos rellenando con los errores encontrados
            if (!isset($_POST['carrera']) || $_POST['carrera'] == "") // nombre carrera
                $errores[] = 'Indique un nombre de carrera valido';
            if (!isset($_POST['fecha']) || $_POST['fecha'] == "") // fecha
                $errores[] = 'Indique una fecha';
            if (!isset($_POST['tipoConsulta'])) // Turno
                $errores[] = 'Indique un tipo de consulta';

            if (!isset($errores)) {
                echo '<h1> Datos recibidos </h1>';
                echo 'Carrera: ' . $_POST['carrera'] . '<br />';
                echo 'Fecha: ' . $_POST['fecha'] . ' <br />';
                echo 'Tipo de consulta: ' . $_POST['tipoConsulta'] . ' <br />';
                $info = explode("\n", $_POST['infoCarrera']);
                $infoOrdenada = Array();

                foreach ($info as $row) {
                    $infopiloto = explode(";", $row);
                    if ($infopiloto[1] == "Pedrosa") {
                        $infoOrdenada[0][] = $infopiloto;
                    }
                    if ($infopiloto[1] == "Marc Marquez") {
                        $infoOrdenada[1][] = $infopiloto;
                    }
                    if ($infopiloto[1] == "Dovicioso") {
                        $infoOrdenada[2][] = $infopiloto;
                    }
                    if ($infopiloto[1] == "Rossi") {
                        $infoOrdenada[3][] = $infopiloto;
                    }
                    if ($infopiloto[1] == "Lorenzo") {
                        $infoOrdenada[4][] = $infopiloto;
                    }
                    if ($infopiloto[1] == "Zarco") {
                        $infoOrdenada[5][] = $infopiloto;
                    }
                }
                //print_r($infoOrdenada);

                $timesPiloto = array(array());
                $i = 0;
                foreach ($infoOrdenada as $piloto) {
                    foreach ($piloto as $row) {
                        $timesPiloto[$i][] = $row[2];
                    }
                    $i++;
                }
                $infoequipos = array();
                foreach ($info as $row) {
                    $infopiloto = explode(";", $row);
                    $trimmed = trim($infopiloto[3]);
                    if ($trimmed == "Repsol Honda Team") {
                        $infoequipos[0][] = $infopiloto;
                    }
                    if ($trimmed == "Ducati Team") {
                        $infoequipos[1][] = $infopiloto;
                    }
                    if ($trimmed == "Movistar Yamaha MotoGP") {
                        $infoequipos[2][] = $infopiloto;
                    }
                }

                $timesequipos = array();
                $i = 0;
                foreach ($infoequipos as $piloto) {
                    foreach ($piloto as $row) {
                        $trimmed = trim($row[3]);
                        $timesequipos[$i][] = $row[2];
                    }
                    $i++;
                }



                if ($_POST['tipoConsulta'] == "vueltaRapida") {
                    ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Nº de vuelta</th>
                                <th>Nombre del piloto</th>
                                <th>Tiempo de vuelta mínimo</th>
                                <th>Equipo</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            for ($i = 0; $i < count($infoOrdenada); $i++) {
                                echo "<tr>";
                                $minTimePiloto = minTime($timesPiloto[$i]);
                                echo "<td>" . $minTimePiloto["vuelta"] . "</td>" . "<td>" . $infoOrdenada[$i][0][1] . "</td>" . "<td>" . $minTimePiloto["tiempo"] . "</td>" . "<td>" . $infoOrdenada[$i][0][3] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                } else if ($_POST['tipoConsulta'] == "vencedor") {

                    //total tiempos pilotos
                    for ($i = 0; $i < count($infoOrdenada); $i++) {
                        $totalTiempos[] = sumTime($timesPiloto[$i]);
                    }
                    ?>	

                    <table border="1">
                        <thead>
                            <tr>
                                <th>Piloto ganador del GP</th>
                                <th>Tiempo total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                echo "<td>" . $infoOrdenada[array_search(min($totalTiempos), $totalTiempos)][0][1] . "</td>";
                                echo "<td>" . min($totalTiempos) . "</td>";
                                ?>

                            </tr>
                        </tbody>
                    </table>
                    <?php
                } else if ($_POST['tipoConsulta'] == "equipoGanador") {
                    //total tiempos equipos
                    for ($i = 0; $i < count($infoequipos); $i++) {
                        $totalTiempos[] = sumTime($timesequipos[$i]);
                    }
                    ?>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Equipo ganador del GP</th>
                                <th>Tiempo total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                echo "<td>" . $infoOrdenada[array_search(min($totalTiempos), $totalTiempos)][0][3] . "</td>";
                                echo "<td>" . min($totalTiempos) . "</td>";
                                ?>

                            </tr>
                        </tbody>
                    </table>
                    <?php
                }
            }
        }

        if (!isset($_POST['envio']) || isset($errores)) {
            echo '<h1> Carreras de MotoGP </h1>';
            if (isset($errores)) {
                echo '<p style="color:red">Errores cometidos:</p>';
                echo '<ul style="color:red">';
                foreach ($errores as $e)
                    echo "<li>$e</li>";
                echo '</ul>';
            }
            ?>		

            <form method="post">
                Nombre de la carrera: <select name="carrera">
                    <option value="jerez">Jerez</option>
                    <option value="motegi">Motegi</option>
                    <option value="sepang">Sepang</option>
                    <option value="montmelo">Montmelo</option>
                </select>
                Fecha: <select name="fecha">
                    <option value="22/06/2018">22/06/2018</option>
                    <option value="10/06/2018">10/06/2018</option>
                    <option value="25/05/2018">25/05/2018</option>
                    <option value="13/05/2018">13/05/2018</option>
                </select>
                Tipo de consulta:<br />
                <input type="radio" name="tipoConsulta" value="vueltaRapida" /> Vuelta rapida<br />
                <input type="radio" name="tipoConsulta" value="vencedor" /> Vencedor<br />
                <input type="radio" name="tipoConsulta" value="equipoGanador" /> Equipo ganador<br />
                Información de la carrera (Formato: nº de vuelta;nombre piloto;tiempo por vuelta;equipo): <br /><textarea name="infoCarrera" rows="30" cols="50">1;Pedrosa;3:15:55;Repsol Honda Team
1;Marc Marquez;3:15:60;Repsol Honda Team
1;Dovicioso;3:15:30;Ducati Team
1;Rossi;3:16:03;Movistar Yamaha MotoGP
1;Lorenzo;3:14:95;Ducati Team
1;Zarco;::;Movistar Yamaha MotoGP
2;Pedrosa;3:14:90;Repsol Honda Team
2;Marc Marquez;3:14:60;Repsol Honda Team
2;Dovicioso;::;Ducati Team
2;Rossi;3:15:30;Movistar Yamaha MotoGP
2;Lorenzo;3:15:09;Ducati Team
2;Zarco;::;Movistar Yamaha MotoGP
3;Pedrosa;3:14:90;Repsol Honda Team
3;Marc Marquez;3:14:60;Repsol Honda Team
3;Dovicioso;::;Ducati Team
3;Rossi;3:15:30;Movistar Yamaha MotoGP
3;Lorenzo;3:15:09;Ducati Team
3;Zarco;::;Movistar Yamaha MotoGP
4;Pedrosa;3:00:90;Repsol Honda Team
4;Marc Marquez;3:14:60;Repsol Honda Team
4;Dovicioso;::;Ducati Team
4;Rossi;3:15:30;Movistar Yamaha MotoGP
4;Lorenzo;3:15:09;Ducati Team
4;Zarco;::;Movistar Yamaha MotoGP
5;Pedrosa;3:14:90;Repsol Honda Team
5;Marc Marquez;3:14:60;Repsol Honda Team
5;Dovicioso;::;Ducati Team
5;Rossi;3:15:30;Movistar Yamaha MotoGP
5;Lorenzo;3:15:09;Ducati Team
5;Zarco;::;Movistar Yamaha MotoGP</textarea><br />

                <input type="submit" name="envio" value="Enviar" />
                <input type="reset" name="rest" value="Restaurar" />			
            </form>			
            <?php
        }
        ?>
    </body>
</html>