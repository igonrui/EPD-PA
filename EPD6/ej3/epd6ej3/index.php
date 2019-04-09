<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['usuario']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Página de inicio</title>
    </head>
    <body>
        <h1>Gestión de partidos Liga Baloncesto Andalucía</h1>
        <?php
        //mensaje de notificacion de exito en el logueo
        if (isset($_SESSION['success'])) {
            unset($_SESSION['success']);
        }

        //USUARIO LOGUEADO
        if (isset($_SESSION['usuario'])) {
            $time = date('d/m/y', strtotime($_SESSION['f_registro']));
            echo "Usuario " . $_SESSION['usuario'] . " desde " . $time;
            //echo "<a href='index.php?logout='1''>logout";
            
            echo "<form action='index.php'><input type='submit' name='logout' value='X'></form>";
        }
        ?>
    </body>
</html>