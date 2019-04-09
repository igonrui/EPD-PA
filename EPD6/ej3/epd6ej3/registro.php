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
        <h2>Registro</h2>
        <form method="post" action="registro.php">
            <?php include('errors.php'); ?>
            <label>Nombre:</label> <input type="text" name="nombre" value="" /><br />
            <label>Usuario:</label><input type="text" name="usuario" value="" /><br />
            <label>Password:</label><input type="password" name="password" value="" /><br />
            <input type="submit" name="registro" value="Registro" />
        </form>
        <?php
        ?>
    </body>
</html>
