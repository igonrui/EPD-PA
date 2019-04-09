<?php

function formulario1() {
    ?>
    <form method="post">
        Circuitos: <br />
        <input type="checkbox" name="circuito[]" value="Jerez" />Jerez<br />
        <input type="checkbox" name="circuito[]" value="Motegi" />Motegi<br />
        <input type="checkbox" name="circuito[]" value="Sepang" />Sepang<br />
        <input type="checkbox" name="circuito[]" value="Montmelo" />Montmelo<br />
        <input type="checkbox" name="circuito[]" value="Silverstone" />Silverstone<br />
        Nº de pilotos por carrera: <input type="number" name="numPilotos" /><br />
        <input type="submit" name="envio1" value="Enviar" />
        <input type="reset" name="rest" value="Restaurar" />			
    </form>			
    <?php
}

function formulario2($circuitos, $numPilotos) {
    for ($j = 0; $j < count($circuitos); $j++) {
        echo '<h2>' . $circuitos[$j] . '</h2>';
        echo 'Fecha: <input name="fecha" type="date"/> <br />';
        ?><form method="post"><table border="1">
                <thead>
                    <tr>
                        <th>Nº de vuelta</th>
                        <th>Nombre del piloto</th>
                        <th>Tiempo de vuelta</th>
                        <th>Equipo</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    for ($i = 0; $i < $numPilotos; $i++) {
                        //numero carrera
                        echo "<tr>\n";
                        echo "\t<td>\n";
                        echo "\t\t<input name='numcarrera" . $j . $i . "' type='number' required />";
                        ;
                        echo "\t</td>\n";

                        //Nombre piloto
                        echo "\t<td>\n";
                        echo "\t\t<input name='nompiloto" . $j . $i . "' type='text' required />";
                        echo "\t</td>\n";

                        //tiempo de vuelta
                        echo "\t<td>\n";
                        echo "\t\t<input name='tiempovuelta" . $j . $i . "' type='time' step='2' required />";
                        echo "\t</td>\n";

                        //equipo
                        echo "\t<td>\n";
                        echo "\t\t<input name='equipo" . $j . $i . "' type='text' required />";
                        echo "\t</td>\n";
                        echo "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            echo "<input name ='circuitos[]' type='hidden' value='" . $circuitos[$j] . "'>";
            echo "<input name ='numPilotos' type='hidden' value='" . $numPilotos . "'>";
        }
        echo'<input type="submit" name="envio2" value="Enviar" />';
        echo'<input type="reset" name="rest" value="Restaurar" /></form>';
    }

    function errors($errores) {
        if (isset($errores)) {
            echo '<p style="color:red">Errores cometidos:</p>';
            echo '<ul style="color:red">';
            foreach ($errores as $e)
                echo "<li>$e</li>";
            echo '</ul>';
        }
    }

    function arrayDeCarreras($circuitos, $numPilotos) {
        $tiempo = array();
        $tiemposPilotos = array();
        for ($j = 0; $j < count($circuitos); $j++) {
            for ($i = 0; $i < $numPilotos; $i++) {
                $tabla[$i][0] = $_POST['numcarrera' . $j . $i];
                $tabla[$i][1] = $_POST['nompiloto' . $j . $i];
                $tabla[$i][2] = $_POST['tiempovuelta' . $j . $i];
                $tabla[$i][3] = $_POST['equipo' . $j . $i];

                $tiempo["nompiloto"] = $_POST['nompiloto' . $j . $i];
                $tiempo["tiempo"] = $_POST['tiempovuelta' . $j . $i];
                array_push($tiemposPilotos, $tiempo);
            }
            echo "Circuito " . $circuitos[$j];
            imprime($tabla, $numPilotos);
            array_push($tiemposPilotos, $tiempo);
        }
        $arr = array();
            foreach ($tiemposPilotos as $key => $item) {
                $arr[$item['nompiloto']] = $item;
            }
            ksort($arr);
        //print_r($arr);
        campeon($arr);
    }

    function imprime($carreras, $numPilotos) {
        echo "<table border = '1'>";
        echo "<tr style='background-color:grey;color:white;'>";
        echo "<th>Nº de vuelta</th>
                <th>Nombre del piloto</th>
                <th>Tiempo de vuelta</th>
                <th>Equipo</th>";
        echo "</tr>";

        for ($i = 0; $i < $numPilotos; $i++) {
            echo "<tr>";
            echo "<td>" . $carreras[$i][0] . "</td>";
            echo "<td>" . $carreras[$i][1] . "</td>";
            echo "<td>" . $carreras[$i][2] . "</td>";
            echo "<td>" . $carreras[$i][3] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function campeon($arr) {
        //sacar un array de tiempos por cada piloto
        
        echo "<h3>Campeon del campeonato de MotoGP</h3>";
        $tiempos = array();
        foreach($arr as $piloto){
            $tiempos[$piloto["nompiloto"]] = $piloto["tiempo"]; 
        }
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>Nombre del piloto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>".array_search(min($tiempos), $tiempos)."</td>
                    </tr>
                </tbody>
            </table>";
    }
    ?>
            
    <html>
        <body>
            <h1>Campeonato de MotoGP</h1>
            <?php
            if (isset($_POST['envio1'])) {
                if (!isset($_POST['circuito']) || count($_POST['circuito']) < 1) { // minimos circuitos
                    $errores[] = 'Seleccione 3 circuitos como minimo';
                if (!isset($_POST['numPilotos']) || $_POST['numPilotos'] = "")
                        $errores[] = 'Introduzca el numero de pilotos por carrera';
                        
                    errors($errores);
                    formulario1();
                } else {
                    formulario2($_POST['circuito'], $_POST['numPilotos']);
                }
            } else if (isset($_POST['envio2'])) {
                $circuitos = $_POST['circuitos'];
                $numPilotos = $_POST['numPilotos'];
                // Comprobamos que los campos obligatorios estan rellenos, creando un vector errores que iremos rellenando con los errores encontrados
                if (!isset($_POST['fecha']) || $_POST['fecha'] == "") // fecha
                    $errores[] = 'Indique una fecha';
                if (isset($errores)) {
                    foreach ($errores as $e) {
                        echo $e;
                    }
                    formulario2($circuitos, $numPilotos);
                } else {
                    //todo es correcto
                    echo "<h3>Carreras Introducidas</h3>";
                    arrayDeCarreras($circuitos, $numPilotos);
                }
            } else {
                formulario1();
            }
            ?>
        </body>
    </html>