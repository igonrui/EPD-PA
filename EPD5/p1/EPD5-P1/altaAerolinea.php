<?php

function formulario1() {
    echo "<h2>Alta aerolinea</h2>";
    echo "<form method='post'>";
    echo "Nombre de la aerolinea: <input type='text' name='aerolinea' required/><br />";
    //obtenemos el maximo numero posible de destinos a seleccionar, segun el numero de ciudades registrados
    if (($f2 = fopen("ciudades.csv", "r")) !== FALSE) {
        while (($vectorCiudades = fgetcsv($f2, 999, "\n")) !== FALSE) {
            $rciudad = explode(",", $vectorCiudades[0]);
        }
        fclose($f2);
    }
    $max = count($rciudad);
    echo "Numero de destinos en los que opera: <input type='number' name='numDestinos' max='$max' min='0' required/><br />";

    echo "<input type='submit' name='envio1' value='Enviar' />";
    echo "<input type='reset' name='rest' value='Restaurar' /> </form>";
}

function formulario2($aerolinea, $numDestinos) {
    echo "<form method='post'>";
    $f = fopen("ciudades.csv", "r");
    $vectorCiudades = fgetcsv($f, 999, ",");
    for ($j = 0; $j < $numDestinos; $j++) {
        echo "Destino " . $j . ": ";
        echo "<select name ='ciudad$j'>";
        for ($i = 0; $i < count($vectorCiudades); $i++) {
            echo "<option value='$vectorCiudades[$i]'>" . $vectorCiudades[$i] . "</option>";
        }
        echo "</select><br/>";
    }
    fclose($f);

    echo "<input name ='hiddenaerolinea' type='hidden' value='$aerolinea'>";
    echo "<input name ='hiddenNumDestinos' type='hidden' value='$numDestinos'>";
    echo'<input type="submit" name="envio2" value="Enviar" /></form>';
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
?>

<html>
    <body>
        <h1>Gestión de vuelos y aerolíneas</h1>
        <?php
        if (isset($_POST['envio1'])) {
            //primero comprueba errores, en cuyo caso llamaria a la funcion errores y mostraría de nuevo el formulario1
            //comprueba si el nombre de la aerolinea ya esta registrado
            if (($f2 = fopen("aerolineas.csv", "r")) !== FALSE) {
                while (($vectorVuelos = fgetcsv($f2, 999, "\n")) !== FALSE) {
                    $raerolinea = explode(";", $vectorVuelos[0]);
                    if ($raerolinea[1] == $_POST['aerolinea']) {
                        $errores[] = 'La aerolinea ya se encuentra registrada';
                    }
                }
                fclose($f2);
            }
            if (isset($errores)) {
                errors($errores);
                formulario1();
            } else {
                //si no hay errores, muestra el formulario 2
                formulario2($_POST['aerolinea'], $_POST['numDestinos']);
            }
        } else if (isset($_POST['envio2'])) {
            $aerolinea = $_POST['hiddenaerolinea'];
            $numDestinos = $_POST['hiddenNumDestinos'];
            for ($i = 0; $i < $numDestinos; $i++) {
                $vectorDestinos[$i] = $_POST['ciudad' . $i];
            }
            //comprobamos si ha introducido origenes duplicados

            if (count($vectorDestinos) != count(array_unique($vectorDestinos))) {
                $errores[] = 'Hay origenes duplicados';
                errors($errores);
                formulario2($aerolinea, $numDestinos);
            } else {
                //obtener id de la aerolinea
                $f = fopen("aerolineas.csv", "r");
                $lines = 0;
                while (!feof($f)) {
                    $line = fgets($f);
                    $lines++;
                }
                fclose($f);

                $f = fopen("aerolineas.csv", "a");
                fwrite($f, $lines); //id aerolinea
                fwrite($f, ";");
                fwrite($f, $aerolinea); //nombre aerolinea
                fwrite($f, "\n");
                fclose($f);


                for ($i = 0; $i < count($vectorDestinos); $i++) {
                    $f = fopen("destinosAerolineas.csv", "a");
                    fwrite($f, $lines); //id aerolinea
                    fwrite($f, ";");
                    fwrite($f, $vectorDestinos[$i]); //nombre aerolinea
                    fwrite($f, "\n");
                    fclose($f);
                }

                //vuelta a la pagina principal
                ?>
                <a href="index.php">Volver a la página principal</a>

                <?php
            }
        } else {


            formulario1();
        }
        ?>
    </body>
</html>