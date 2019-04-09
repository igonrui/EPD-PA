<?php include('servidor.php');

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['usuario']);
    header("location: index.php");
}

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Gestión de partidos Liga Baloncesto Andalucía</h1>
        <!--<nav><a href="altaEquipo.php">Alta equipo</a> || <a href="altaPartido.php">Alta partido</a> || <a href="clasificacion.php">Clasificacion</a> || <a href="index.php">Página principal</a></nav>-->
        <h2>Clasificación</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Partidos Jugados</th>
                    <th>Partidos Ganados</th>
                    <th>Partidos Perdidos</th>
                    <th>Puntos a Favor</th>
                    <th>Puntos en contra</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($filasClasificacion as $fila){
                    echo "<tr>";
                    foreach($fila as $dato){
                        echo "<td>".$dato."</td>";
                    }
                    echo"</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index.php">Volver a la página principal</a><br/>
        <?php
        //USUARIO LOGUEADO
        if (isset($_SESSION['usuario'])) {
            $time = date('d/m/y', strtotime($_SESSION['f_registro']));
            echo "Usuario " . $_SESSION['usuario'] . " desde " . $time;
            echo "<form action='index.php'><input type='submit' name='logout' value='X'></form>";
        }
        ?>
    </body>
</html>
