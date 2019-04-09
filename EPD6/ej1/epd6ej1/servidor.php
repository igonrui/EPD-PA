<?php

//para almacenar la sesion entre las distintas paginas de php en las que el usuario navegue
session_start();

$errors = array();
// Conectar a la BD
$db = mysqli_connect('localhost', 'root', '', 'epd6-p1');
if (!$db) {
    die(' No puedo conectar: ' . mysqli_error());
}

// REGISTRO
if (isset($_POST['registro'])) {

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    //Validar que los campos estan rellenos
    if (empty($nombre)) {
        array_push($errors, "Introduzca un nombre");
    }
    if (empty($usuario)) {
        array_push($errors, "Introduzca un usuario");
    }
    if (empty($password)) {
        array_push($errors, "Introduzca una contraseña");
    }

    // primero comprueba en la base de datos si ya existe ese usuario
    $user_check_query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($db, $user_check_query) or die("Fallo en la consulta: " . $user_check_query);
    $user = mysqli_fetch_assoc($result); //fila que devuelve la consulta, es un array asociativo con los campos de las columnas de la tabla en la BD

    if ($user) { // si el usuario existe
        if ($user['usuario'] === $usuario) {
            array_push($errors, "El usuario ya existe");
        }
    }
    // Finalmente, registra al usuario si no hay erorres en el formulario
    if (count($errors) == 0) {
        $query = "INSERT INTO usuarios (nombre, usuario, password, f_registro) VALUES ('$nombre', '$usuario', '$password', NOW())"; //NOW() devuelve la fecha del servidor de la BD
        mysqli_query($db, $query) or die("Fallo en la consulta: " . $query);
        mysqli_close($db);
        header('location: index.php');
    }
}

// LOGIN
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (empty($usuario)) {
        array_push($errors, "Introduzca un usuario");
    }
    if (empty($password)) {
        array_push($errors, "Introduzca una contraseña");
    }

    // Finalmente, registra al usuario si no hay erorres en el formulario
    if (count($errors) == 0) {

        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
        //ejecutamos la consulta
        $resultado = mysqli_query($db, $query) or die("Fallo en la consulta: " . $query);


        if (mysqli_num_rows($resultado) == 1) {
            //guardamos el resultado
            $fila = mysqli_fetch_assoc($resultado);
            mysqli_close($db);
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['f_registro'] = $fila['f_registro'];
            $_SESSION['success'] = "Ya estás logueado";
            header('location: index.php');
        } else {
            mysqli_close($db);
            array_push($errors, "No se encuentra un usuario con esa contraseña");
            header('location: registro.php');
        }
    }
}

mysqli_close($db);