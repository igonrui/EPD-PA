<?php

function formulario1() {
    echo "<h2>Origen: </h2>";
    echo "<form method='post'>";
    if (($f1 = fopen("aerolineas.csv", "r")) !== FALSE) {
        while (($vectorAerolineas = fgetcsv($f1, 999, "\n")) !== FALSE) {
            //seleccionamos  cada aerolinea
            for ($i = 0; $i < count($vectorAerolineas); $i++) {
                $aerolinea = explode(";", $vectorAerolineas[$i]);
                echo "Aerolinea: " . $aerolinea[1];
                echo "<br/>";

                //para cada aerolinea buscamos sus correspondientes destinos en el archivo de destinos
                if (($f2 = fopen("destinosAerolineas.csv", "r")) !== FALSE) {
                    while (($vectorDestinosAerolineas = fgetcsv($f2, 999, "\n")) !== FALSE) {
                        //print_r($vectorDestinosAerolineas);
                        //echo "<br/>";
                        for ($j = 0; $j < count($vectorDestinosAerolineas); $j++) {
                            $destino = explode(";", $vectorDestinosAerolineas[$j]);
                            if ($aerolinea[0] == $destino[0]) { //si tienen el mismo id, es decir son la misma aerolinea
                                $valorSeleccion = array($destino[0] => $destino[1]);
                                echo "<input type='radio' name='aerolineaOrigen' value='$destino[0];$destino[1]' checked/>" . $destino[1];
                                echo "<br/>";
                            }
                        }
                    }
                    fclose($f2);
                }
            }
        }
        fclose($f1);
    }

    echo'<input type="submit" name="envio1" value="Enviar" /></form>';
}

function formulario2($aerolineaOrigen) {
    $datos = explode(";", $aerolineaOrigen);

    //primera seleccion: obtener todas las ciudades en las que opera esa aerolinea, excepto la que se ha elegido en el formulario1
    if (($f1 = fopen("destinosAerolineas.csv", "r")) !== FALSE) {
        while (($vectorDestinosAerolineas = fgetcsv($f1, 999, "\n")) !== FALSE) {
            for ($i = 0; $i < count($vectorDestinosAerolineas); $i++) {
                $ciudadesAerolinea = explode(";", $vectorDestinosAerolineas[$i]);

                if ($datos[0] == $ciudadesAerolinea[0] && $ciudadesAerolinea[1] != $datos[1]) {
                    $destinosTotales[] = $ciudadesAerolinea[1];
                }
            }
        }
        fclose($f1);
    }



    //segunda seleccion: comparar las ciudades donde opera la aerolinea y las ciudades que ya estan fijadas como destino
    $destinosPillados = array(); //primero lo inicializo para el caso en que no hubiese ningun destino asignado a ese origen
    if (($f2 = fopen("vuelos.csv", "r")) !== FALSE) {
        while (($vectorVuelos = fgetcsv($f2, 999, "\n")) !== FALSE) {
            $destino = explode(";", $vectorVuelos[0]);

            //busca los destinos que hay cogidos para ese origen seleccionado en el formulario1
            if ($destino[0] == $datos[0] && $destino[1] == $datos[1]) {
                $destinosPillados[] = $destino[2];
            }
        }
        fclose($f2);
    }

    //resta los pillados a los totales, y obtiene los disponibles
    $destinosDisponibles = array_diff($destinosTotales, $destinosPillados);
    sort($destinosDisponibles); //lo ordenamos para que los indices nos salgan ordenados

    echo "<h3>Origen: " . $datos[1] . "</h3>";
    if (empty($destinosDisponibles)) {
        echo "El origen " . $datos[1] . " ya se ha conectado con todos los destinos disponibles para la aerolínea";
    } else {
        echo "Seleccione destino: ";
        echo "<form method='post'><select name='destino'>";
        for ($i = 0; $i < count($destinosDisponibles); $i++) {
            echo "<option value='$destinosDisponibles[$i]'>" . $destinosDisponibles[$i] . "</option>";
        }
        echo "</select><br/>";

        echo "Tiempo de vuelo: <input name='duracion' type='time' required />";
        echo "<input name ='hiddenIdAerolinea' type='hidden' value='$datos[0]'>";
        echo "<input name ='hiddenOrigen' type='hidden' value='$datos[1]'>";

        echo'<input type="submit" name="envio2" value="Enviar" /></form>';
    }
}
?>

<html>
    <body>
        <h1>Gestión de vuelos y aerolíneas</h1>
        <?php
        if (isset($_POST['envio1'])) {
            formulario2($_POST['aerolineaOrigen']);
        } else if (isset($_POST['envio2'])) {
            $idAerolinea = $_POST['hiddenIdAerolinea'];
            $origen = $_POST['hiddenOrigen'];
            $destino = $_POST['destino'];
            $duracion = $_POST['duracion'];


            $f = fopen("vuelos.csv", "a");
            fwrite($f, $idAerolinea); //id aerolinea
            fwrite($f, ";");
            fwrite($f, $origen); //origen
            fwrite($f, ";");
            fwrite($f, $destino); //destino
            fwrite($f, ";");
            fwrite($f, $duracion); //duracion
            fwrite($f, "\n");
            fclose($f);

            //vuelta a la pagina principal
            ?>
            <a href="index.php">Volver a la página principal</a>


            <?php
        } else {
            formulario1();
        }
        ?>
    </body>
</html>