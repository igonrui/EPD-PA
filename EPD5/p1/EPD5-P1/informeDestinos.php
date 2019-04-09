<?php

function formulario1() {

    echo "<h2>Informe resumen aerolínea</h2><form method='post'>";

    if (($f2 = fopen("aerolineas.csv", "r")) !== FALSE) {
        while (($vectorAerolineas = fgetcsv($f2, 999, "\n")) !== FALSE) {
            $aerolinea = explode(";", $vectorAerolineas[0]);
            echo "<input type='radio' name='aerolinea' value='$aerolinea[0]' checked/>" . $aerolinea[1] . "<br/>";
        }
        fclose($f2);
    }

    echo "<input type='submit' name='envio' value='Enviar' /></form>";
}

function sumarTiempo($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }
    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}

function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}
?>

<html>
    <body>
        <h1>Gestión de vuelos y aerolíneas</h1>
        <?php
        if (isset($_POST['envio'])) {

            //dado el id de la aerolinea, obtengo toda la informacion que tenga sobre ella en el archivo vuelos.csv
            if (($f2 = fopen("vuelos.csv", "r")) !== FALSE) {
                while (($vectorAerolineas = fgetcsv($f2, 999, "\n")) !== FALSE) {
                    $aerolinea = explode(";", $vectorAerolineas[0]);
                    if ($aerolinea[0] == $_POST['aerolinea']) {
                        $infoVuelos[] = $aerolinea;
                    }
                }
                fclose($f2);
            }

            //en caso de que la aerolinea seleccionada tenga vuelos registrados
            if (isset($infoVuelos)) {

                //obtenemos todos las ciudades en las que opera esa aerolinea
                $infoCiudades = array();
                if (($f2 = fopen("destinosAerolineas.csv", "r")) !== FALSE) {
                    while (($vectorCiudades = fgetcsv($f2, 999, "\n")) !== FALSE) {
                        $ciudad = explode(";", $vectorCiudades[0]);
                        if ($ciudad[0] == $_POST['aerolinea']) {
                            array_push($infoCiudades, $ciudad[1]);
                        }
                    }
                    fclose($f2);
                }

                //obtener numero de conexiones y su tiempo
                $destinos = array();
                $origenes = array();

                //obtenemos un array de los origenes y los destinos
                foreach ($infoVuelos as $conexion) {
                    array_push($origenes, $conexion[1]);
                    array_push($destinos, $conexion[2]);
                }

                //obtenemos un array que por cada clave(por cada origen/destino), tenga el valor de cuantas veces aparece esa clave en el array (funcion array_count_values)
                $totalOrigenes = array_count_values($origenes);
                $totalDestinos = array_count_values($destinos);

                //Unimos toda la info sumando lo que hay en origenes y en destinos
                //inicializamos a 0 todos los elementos
                for ($i = 0; $i < count($infoCiudades); $i++) {
                    $totalCiudades[$infoCiudades[$i]] = 0; //inicializamos este vector que usaremos para procesar la informacion al final
                }

                foreach ($totalOrigenes as $origen => $numOrigen) {
                    $totalCiudades[$origen] += $numOrigen;
                }

                foreach ($totalDestinos as $destino => $numDestino) {
                    $totalCiudades[$destino] += $numDestino;
                }

                //calcular tiempo medio de cada destino
                //array tiempo de origenes
                $arrayTiempos = array();
                $origenesUnicos = array_unique($origenes);
                foreach ($origenesUnicos as $origen => $ciudad) {
                    foreach ($infoVuelos as $vuelo => $info) {
                        if ($ciudad == $info[1]) {
                            if (!key_exists($ciudad, $arrayTiempos)) {
                                $arrayTiempos[$ciudad] = $info[3];
                            } else {
                                $tiempos = sumarTiempo(array($arrayTiempos[$ciudad], $info[3]));
                                $arrayTiempos[$ciudad] = $tiempos;
                            }
                        }
                    }
                }
                //array tiempo de destinos
                $destinosUnicos = array_unique($destinos);
                foreach ($destinosUnicos as $destino => $ciudad) {
                    foreach ($infoVuelos as $vuelo => $info) {
                        if ($ciudad == $info[2]) {
                            if (!key_exists($ciudad, $arrayTiempos)) {
                                $arrayTiempos[$ciudad] = $info[3];
                            } else {
                                $tiempos = sumarTiempo(array($arrayTiempos[$ciudad], $info[3]));
                                $arrayTiempos[$ciudad] = $tiempos;
                            }
                        }
                    }
                }

                //ordenar array de ciudades descendentemente por conexiones
                uasort($totalCiudades, 'cmp');
                
                //unir toda la informacion en un solo array para recorrerlo posteriormente
                $informeResumen = array_merge_recursive($totalCiudades, $arrayTiempos);

                //mostrar el contenido del array en una tabla
                echo "<table border='1'><thead><tr><th>Nombre destino</th><th>Numero de conexiones</th><th>Tiempo medio</th></tr></thead>";
                echo "<tbody>";
                foreach ($informeResumen as $ciudad => $datos) {
                    echo "<tr><td>$ciudad</td>";
                    echo "<td>$datos[0]</td>";
                    echo "<td>$datos[1]</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";

                //vuelta a la pagina principal
                ?>
                <a href="index.php">Volver a la página principal</a>


                <?php
            }else{
                echo "La aerolinea seleccionada no tiene vuelos registrados actualmente<br/>";
                ?>
                <a href="index.php">Volver a la  principal</a>
                <?php
            }
        } else {
            formulario1();
        }
        ?>
    </body>
</html>