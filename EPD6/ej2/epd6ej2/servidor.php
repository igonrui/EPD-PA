<?php

//para almacenar la sesion entre las distintas paginas de php en las que el usuario navegue
session_start();

$errors = array();
// Conectar a la BD
$db = mysqli_connect('localhost', 'root', '', 'epd6-p1') or die("Error conectando a la base de datos");
if (!$db) {
    die(' No puedo conectar: ' . mysqli_error());
}
// REGISTRO
if (isset($_POST['registro'])) {
    //Validar que los campos estan rellenos
    if (empty($_POST['nombre'])) {
        array_push($errors, "Introduzca un nombre");
    }
    if (empty($_POST['usuario'])) {
        array_push($errors, "Introduzca un usuario");
    }
    if (empty($_POST['password'])) {
        array_push($errors, "Introduzca una contraseña");
    }

    //para evitar la inyeccion sql (que sería con un ' OR 1=1 #)
    $filtros = array('nombre' => FILTER_SANITIZE_STRING, 'usuario' => FILTER_SANITIZE_STRING, 'password' => FILTER_SANITIZE_STRING);
    $entradas = filter_input_array(INPUT_POST, $filtros); //aplica los filtros a los campos de entrada

    if (array_search(false, $entradas, true) || array_search(NULL, $entradas, true)) {
        echo "Error en los datos del formulario";
    } else {
        //ahora todos los campos tenemos que recibirlos de otra forma
        $nombre = $entradas['nombre'];
        $usuario = $entradas['usuario'];
        $password = $entradas['password'];

        // primero comprueba en la base de datos si ya existe ese usuario
        $user_check_query = "SELECT * FROM usuarios WHERE usuario='$usuario'";
        $resultado = mysqli_query($db, $user_check_query) or die("Fallo en la consulta: " . $user_check_query);
        $fila = mysqli_fetch_assoc($resultado); //fila que devuelve la consulta, es un array asociativo con los campos de las columnas de la tabla en la BD

        if ($fila) { // si el usuario existe
            if ($fila['usuario'] === $usuario) {
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
}

// LOGIN
if (isset($_POST['login'])) {

    if (empty($_POST['usuario'])) {
        array_push($errors, "Introduzca un usuario");
    }
    if (empty($_POST['password'])) {
        array_push($errors, "Introduzca una contraseña");
    }
    //para evitar la inyeccion sql (que sería con un ' OR 1=1 #)
    $filtros = array('usuario' => FILTER_SANITIZE_STRING, 'password' => FILTER_SANITIZE_STRING);
    $entradas = filter_input_array(INPUT_POST, $filtros); //aplica los filtros a los campos de entrada

    if (array_search(false, $entradas, true) || array_search(NULL, $entradas, true)) {
        echo "Error en los datos del formulario";
    } else {
        //ahora todos los campos tenemos que recibirlos de otra forma
        $usuario = $entradas['usuario'];
        $password = $entradas['password'];

        // Finalmente, registra al usuario si no hay erorres en el formulario
        if (count($errors) == 0) {
            $query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";
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
}