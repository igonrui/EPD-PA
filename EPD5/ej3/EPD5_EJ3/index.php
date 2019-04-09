<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

function formulario1() {
    ?>
    <form method="post">
        Nombre completo: <input type="text" name="nombre"/><br />
        Email: <input type="text" name="email" /><br />
        Usuario Twitter <input type="text" name="twitter" /><br />
        Telefono fijo: <input type="text" name="fijo" /><br />
        Telefono movil: <input type="text" name="movil" /><br />
        Provincia: <select name="provincia">
            <option value="Almeria">Almeria</option>
            <option value="Cadiz">Cadiz</option>
            <option value="Cordoba">Cordoba</option>
            <option value="Huelva">Huelva</option>
            <option value="Granada">Granada</option>
            <option value="Jaen">Jaen</option>
            <option value="Malaga">Malaga</option>
            <option value="Sevilla" selected>Sevilla</option>
        </select><br />
        Descripcion de la ruta de senderismo: 
        <textarea rows="7" cols="50" name="descripcion"></textarea><br />
        <input type="submit" name="envio" value="Enviar" />
        <input type="reset" name="rest" value="Restaurar" />	
    </form>			
    <?php
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
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Rutas de senderismo de Andalucía</h1>
        <?php
        if (isset($_POST['envio'])) { //si se pulsa el submit de envio
            //se comprueba si todos los campos estan rellenos
            if (!isset($_POST['nombre']) || $_POST['nombre'] == "" || !preg_match('/^[A-Z]/', $_POST['nombre']))
                $errores[] = 'Indique un nombre completo --> EJ: Nxxxx Ayyyyy';
            
            if (!filter_has_var(INPUT_POST, "email")) {
                echo("Input type does not exist");
            } else {
                if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
                    $errores[]='Indique un email valido --> EJ: xxxxx@yyy.zzz';
                }
            }
            if (!isset($_POST['fijo']) || $_POST['fijo'] == "" || !preg_match('/^9[[:digit:]]{8}$/', $_POST['fijo']))
                $errores[] = 'Indique un telefono fijo valido --> EJ: 9xxxxxxxx';
            if (!isset($_POST['movil']) || $_POST['movil'] == "" || !preg_match('/^6[[:digit:]]{8}$/', $_POST['movil']))
                $errores[] = 'Indique un telefono movil valido --> EJ: 6xxxxxxxx';
            if (!isset($_POST['twitter']) || $_POST['twitter'] == "" || !preg_match('/^[@]/', $_POST['twitter']))
                $errores[] = 'Indique un usuario de Twitter --> EJ: @xxxx';
            if (!isset($_POST['descripcion']) || $_POST['descripcion'] == "")
                $errores[] = 'Indique una descripcion';

            //Saneamiento de entradas
            
            if (!filter_has_var(INPUT_POST, "nombre")) {
                echo("Input type does not exist");
            } else {
                $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
            }
            if (!filter_has_var(INPUT_POST, "email")) {
                echo("Input type does not exist");
            } else {
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            }
            if (!filter_has_var(INPUT_POST, "fijo")) {
                echo("Input type does not exist");
            } else {
                $fijo = filter_input(INPUT_POST, "fijo", FILTER_SANITIZE_NUMBER_INT);
            }
            if (!filter_has_var(INPUT_POST, "movil")) {
                echo("Input type does not exist");
            } else {
                $movil = filter_input(INPUT_POST, "movil", FILTER_SANITIZE_NUMBER_INT);
            }
            if (!filter_has_var(INPUT_POST, "twitter")) {
                echo("Input type does not exist");
            } else {
                $twitter = filter_input(INPUT_POST, "twitter", FILTER_SANITIZE_STRING);
            }
            if (!filter_has_var(INPUT_POST, "descripcion")) {
                echo("Input type does not exist");
            } else {
                $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
            }

            //muestra la informacion
            if (!isset($errores)) {
                echo "Nombre completo: " . $nombre . "<br/>";
                echo "Email: " . $email . "<br/>";
                echo "Usuario Twitter: " . $twitter . "<br/>";
                echo "Telefono fijo: " . $fijo . "<br/>";
                echo "Telefono movil: " . $movil . "<br/>";
                echo "Provincia: " . $_POST['provincia'] . "<br/>";
                echo "Descripción de la ruta de senderismo: " . $descripcion . "<br/>";
            }
        }


        if (!isset($_POST['envio']) || isset($errores)) { //si no se ha pulsado el submit de envio o hay errores
            if (isset($errores)) //si el array de errores contiene informacion
                errors($errores);

            //muestra el formulario
            formulario1();
        }
        ?>
    </body>
</html>