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
            <option value="almeria">Almeria</option>
            <option value="cadiz">Cadiz</option>
            <option value="cordoba">Cordoba</option>
            <option value="huelva">Huelva</option>
            <option value="granada">Granada</option>
            <option value="jaen">Jaen</option>
            <option value="malaga">Malaga</option>
            <option value="sevilla" selected>Sevilla</option>
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
            if (!isset($_POST['nombre']) || $_POST['nombre'] == "")
                $errores[] = 'Indique un nombre completo';
            if (!isset($_POST['email']) || $_POST['email'] == "")
                $errores[] = 'Indique un email';
            if (!isset($_POST['twitter']) || $_POST['twitter'] == "")
                $errores[] = 'Indique un usuario de Twitter';
            if (!isset($_POST['fijo']) || $_POST['fijo'] == "")
                $errores[] = 'Indique un numero fijo';
            if (!isset($_POST['movil']) || $_POST['movil'] == "")
                $errores[] = 'Indique un numero de movil';
            if (!isset($_POST['descripcion']) || $_POST['descripcion'] == "")
                $errores[] = 'Indique una descripcion';

            //muestra la informacion
            if (!isset($errores)) {
                echo "Nombre completo: " . $_POST['nombre'] . "<br/>";
                echo "Email: " . $_POST['email'] . "<br/>";
                echo "Usuario Twitter: " . $_POST['twitter'] . "<br/>";
                echo "Telefono fijo: " . $_POST['fijo'] . "<br/>";
                echo "Telefono movil: " . $_POST['movil'] . "<br/>";
                echo "Provincia: " . $_POST['provincia'] . "<br/>";
                echo "Descripción de la ruta de senderismo: " . $_POST['descripcion'] . "<br/>";
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
