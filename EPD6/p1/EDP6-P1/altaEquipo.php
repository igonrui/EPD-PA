<?php
include('servidor.php');

if (!isset($_SESSION['usuario'])) {
    $_SESSION['pagina'] = "altaEquipo.php";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['usuario']);
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Gestión de partidos Liga Baloncesto Andalucía</h1>
        <h2>Alta equipo</h2>
        <!--<nav><a href="altaEquipo.php">Alta equipo</a> || <a href="altaPartido.php">Alta partido</a> || <a href="clasificacion.php">Clasificacion</a> || <a href="index.php">Página principal</a></nav>-->
        <form action="altaEquipo.php" method="POST">
            <?php include('errors.php'); ?>
            <label>Nombre equipo: </label> <input type="text" name="nombreEquipo" /> <br/>
            <label>Ciudad del equipo: </label> 
            <select name="ciudad">
                <?php
                for ($i = 0; $i < count($filasCiudades); $i++) {
                    $ciudad = $filasCiudades[$i][0];
                    echo "<option value='$ciudad'>" . $ciudad . "</option>";
                }
                ?>
            </select><br/>
            <input type="submit" name="altaEquipoForm" value="Enviar"/>
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