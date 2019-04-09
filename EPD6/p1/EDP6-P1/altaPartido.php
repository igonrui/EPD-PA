<?php
include('servidor.php');

if (!isset($_SESSION['usuario'])) {
    $_SESSION['pagina'] = "altaPartido.php";
    header('location: login.php');
}
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
        <h2>Alta partido</h2>
        <form action="altaPartido.php" method="POST">
            <?php include('errors.php'); ?>

            <label>Local: </label> 
            <select name="equipoLocal">
                <?php
                for ($i = 0; $i < count($filasEquipos); $i++) {
                    $equipos = $filasEquipos[$i][0];
                    echo "<option value='$equipos'>" . $equipos . "</option>";
                }
                ?>
            </select>
            <input type="number" name="puntuacionLocal" /> -
            <input type="number" name="puntuacionVisitante" />

            <label>Visitante: </label> 
            <select name="equipoVisitante">
                <?php
                for ($i = 0; $i < count($filasEquipos); $i++) {
                    $equipos = $filasEquipos[$i][0];
                    echo "<option value='$equipos'>" . $equipos . "</option>";
                }
                ?>
            </select><br/>
            <input type="submit" name="altaPartidoForm" value="Guardar">
        </form>
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
