<?php include('servidor.php') ?>
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
        <h2>Login</h2>

        <form method="post" action="login.php" >
            <?php include('errors.php'); ?>
            <label>Usuario:</label> <input type="text" name="usuario"/> <br />
            <label>Password:</label> <input type="password" name="password"/> <br />
            <input type="submit" name="login" value="Entrar" />
        </form>

        <form method="post" action="registro.php">
            <input type="submit" value="Registro" />
        </form>
        <a href="index.php">Volver a la página principal</a>

    </body>
</html>
