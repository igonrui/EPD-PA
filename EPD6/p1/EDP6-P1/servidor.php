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
            $password = password_hash($password, PASSWORD_DEFAULT); //encryptamos la contraseña antes de guardarla en la BD
            $query = "INSERT INTO usuarios (nombre, usuario, password, f_registro) VALUES ('$nombre', '$usuario', '$password', NOW())"; //NOW() devuelve la fecha del servidor de la BD
            mysqli_query($db, $query) or die("Fallo en la consulta: " . $query);
            mysqli_close($db);
            header('location: '.$_SESSION["pagina"]);
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
            //primero buscamos el usuario al que se quiere acceder
            $consulta = "SELECT * FROM usuarios WHERE usuario='$usuario'";
            $resultado = mysqli_query($db, $consulta) or die("Fallo en la consulta: " . $consulta);
            $fila = mysqli_fetch_assoc($resultado);
            mysqli_close($db);

            //a continuacion comprobamos si la contraseña proporcionada por el usuario coincide con la contraseña que tiene en la BD (verificando el codigo hash)
            if (password_verify($password, $fila['password'])) {
                $_SESSION['usuario'] = $fila['usuario'];
                $_SESSION['f_registro'] = $fila['f_registro'];
                $_SESSION['success'] = "Ya estás logueado";
                header('location: '.$_SESSION["pagina"]);
            } else {
                array_push($errors, "No se encuentra un usuario con esa contraseña");
                header('location: registro.php');
            }
        }
    }
}


// altaEquipo
if (isset($_POST['altaEquipo']) || isset($_POST['altaEquipoForm'])) {

    //----------Displays del formulario
    //Display de ciudades
    $consultaCiudades = "SELECT * FROM ciudades";
    $resultadoCiudades = mysqli_query($db, $consultaCiudades) or die("Fallo en la consulta: " . $consultaCiudades);
    $filasCiudades = mysqli_fetch_all($resultadoCiudades);

    //asignar id segun el numero de equipos registrados
    $consultaEquipos = "SELECT * FROM equipos";
    $resultadoEquipos = mysqli_query($db, $consultaEquipos) or die("Fallo en la consulta: " . $consultaCiudades);
    $filasEquipos = mysqli_fetch_all($resultadoEquipos);
    $numCiudades = count($filasEquipos);
}

//----------Procesamiento del formulario
//Validar que los campos estan rellenos
if (isset($_POST['altaEquipoForm'])) {
    if (!isset($_POST['nombreEquipo']) || $_POST['nombreEquipo'] == '') {
        array_push($errors, "Introduzca un nombre del equipo");
    }

    //para evitar la inyeccion sql (que sería con un ' OR 1=1 #)
    $nombreEquipo = filter_var($_POST['nombreEquipo'], FILTER_SANITIZE_STRING); //aplica los filtros a los campos de entrada

    $ciudad = $_POST['ciudad'];

    // primero comprueba en la base de datos si ya existe ese equipo
    $user_check_query = "SELECT * FROM equipos WHERE nombre='$nombreEquipo'";
    $resultado = mysqli_query($db, $user_check_query) or die("Fallo en la consulta: " . $user_check_query);
    $fila = mysqli_fetch_assoc($resultado); //fila que devuelve la consulta, es un array asociativo con los campos de las columnas de la tabla en la BD

    if ($fila) { // si el equipo existe
        if ($fila['nombre'] === $nombreEquipo) {
            array_push($errors, "El equipo ya existe");
        }
    }
    // Finalmente, registra al equipo si no hay erorres en el formulario
    if (count($errors) == 0) {
        $id = $numCiudades;
        $query = "INSERT INTO equipos (id, nombre, ciudad) VALUES ('$id', '$nombreEquipo', '$ciudad')";
        mysqli_query($db, $query) or die("Fallo en la consulta: " . $query);
    }
}


// altaPartido
if (isset($_POST['altaPartido']) || isset($_POST['altaPartidoForm'])) {

    //----------Displays del formulario
    //Display de equipos
    $consultaEquipos = "SELECT nombre FROM equipos";
    $resultadoEquipos = mysqli_query($db, $consultaEquipos) or die("Fallo en la consulta: " . $consultaEquipos);
    $filasEquipos = mysqli_fetch_all($resultadoEquipos);
}

if (isset($_POST['altaPartidoForm'])) {
    if (empty($_POST['puntuacionLocal'])) {
        array_push($errors, "Introduzca una puntuación al equipo Local");
    }

    if (!isset($_POST['puntuacionVisitante']) || $_POST['puntuacionVisitante'] == '') {
        array_push($errors, "Introduzca una puntuación al equipo Visitante");
    }

    $nombreLocal = $_POST['equipoLocal'];
    $nombreVisitante = $_POST['equipoVisitante'];
    $puntuacionLocal = $_POST['puntuacionLocal'];
    $puntuacionVisitante = $_POST['puntuacionVisitante'];

    //obtener el id de los equipos-----------
    $consultaIdLocal = "SELECT id FROM equipos WHERE nombre='$nombreLocal'";
    $resultadoIdLocal = mysqli_query($db, $consultaIdLocal) or die("Fallo en la consulta: " . $consultaIdLocal);
    $filasIdLocal = mysqli_fetch_assoc($resultadoIdLocal);
    $idLocal = $filasIdLocal['id'];

    $consultaIdVisitante = "SELECT id FROM equipos WHERE nombre='$nombreVisitante'";
    $resultadoIdVisitante = mysqli_query($db, $consultaIdVisitante) or die("Fallo en la consulta: " . $consultaIdVisitante);
    $filasIdVisitante = mysqli_fetch_assoc($resultadoIdVisitante);
    $idVisitante = $filasIdVisitante['id'];

    // primero comprueba si los equipos elegidos como local y visitante son los mismos
    if ($idLocal === $idVisitante) {
        array_push($errors, "El equipo Local coincide con el equipo Visitante");
    }

    //posteriormente comprueba si el partido no se ha jugado ya
    $consultaPartido = "SELECT * FROM partidos WHERE id_local = '$idLocal' AND id_visitante = '$idVisitante'";
    $resultadoPartido = mysqli_query($db, $consultaPartido) or die("Fallo en la consulta: " . $consultaPartido);
    if (mysqli_num_rows($resultadoPartido) > 0) {
        array_push($errors, "El partido ya se encuentra registrado en el sistema");
    }

    // Finalmente, inserta el partido si no hay erorres en el formulario
    if (count($errors) == 0) {
        $query = "INSERT INTO partidos (id_local, id_visitante, puntuacion_local, puntuacion_visitante) VALUES ('$idLocal', '$idVisitante', '$puntuacionLocal', '$puntuacionVisitante')";
        mysqli_query($db, $query) or die("Fallo en la consulta: " . $query);

        //actualiza la informacion de la tabla equipos----------------
        //calculamos ganador
        if ($puntuacionLocal < $puntuacionVisitante) {
            $ganador = "Visitante";
        } else if ($puntuacionLocal > $puntuacionVisitante) {
            $ganador = "Local";
        } else {
            $ganador = "Empate";
        }

        //primero obtiene los datos que hay actualmente en la tabla
        $datosLocal = "SELECT PJ, PG, PP, PF, PE FROM equipos WHERE nombre='$nombreLocal'";
        $resultadoLocal = mysqli_query($db, $datosLocal) or die("Fallo en la consulta: " . $datosLocal);
        $filasLocal = mysqli_fetch_assoc($resultadoLocal);

        $datosVisitante = "SELECT PJ, PG, PP, PF, PE FROM equipos WHERE nombre='$nombreVisitante'";
        $resultadoVisitante = mysqli_query($db, $datosVisitante) or die("Fallo en la consulta: " . $datosVisitante);
        $filasVisitante = mysqli_fetch_assoc($resultadoVisitante);

        //partidos jugados
        $pjLocal = $filasLocal['PJ'] + 1;
        $pjVisitante = $filasVisitante['PJ'] + 1;

        //partidos ganados y perdidos
        if ($ganador == "Local") {
            $pgLocal = $filasLocal['PG'] + 1;
            $ppLocal = $filasLocal['PP'];
            $ppVisitante = $filasVisitante['PP'] + 1;
            $pgVisitante = $filasVisitante['PG'];
        } else if ($ganador == "Visitante") {
            $pgVisitante = $filasVisitante['PG'] + 1;
            $ppVisitante = $filasVisitante['PP'];
            $pgLocal = $filasLocal['PG'];
            $ppLocal = $filasLocal['PP'] + 1;
        } else if ($ganador == "Empate") {
            $pgVisitante = $filasVisitante['PG'];
            $ppVisitante = $filasVisitante['PP'];
            $pgLocal = $filasLocal['PG'];
            $ppLocal = $filasLocal['PP'];
        }
        //puntos a favor y en contra
        $pfLocal = $filasLocal['PF'] + $puntuacionLocal;
        $peLocal = $filasLocal['PE'] + $puntuacionVisitante;
        $pfVisitante = $filasVisitante['PF'] + $puntuacionVisitante;
        $peVisitante = $filasVisitante['PE'] + $puntuacionLocal;

        $queryLocal = "UPDATE equipos set PJ = '$pjLocal', PG = '$pgLocal', PP ='$ppLocal', PF = '$pfLocal', PE='$peLocal' WHERE id='$idLocal'";
        mysqli_query($db, $queryLocal) or die("Fallo en la consulta: " . $queryLocal);

        $queryVisitante = "UPDATE equipos set PJ = '$pjVisitante', PG = '$pgVisitante', PP ='$ppVisitante', PF = '$pfVisitante', PE='$peVisitante' WHERE id='$idVisitante'";
        mysqli_query($db, $queryVisitante) or die("Fallo en la consulta: " . $queryVisitante);
    }
}

// clasificacion
if (isset($_POST['clasificacion'])) {
    $consultaClasificacion = "SELECT nombre, PJ, PG, PP, PF, PE FROM equipos ORDER BY PG DESC, PF DESC";
    $resultadoClasificacion = mysqli_query($db, $consultaClasificacion) or die("Fallo en la consulta: " . $consultaClasificacion);
    $filasClasificacion = mysqli_fetch_all($resultadoClasificacion, MYSQLI_ASSOC);
}

mysqli_close($db);
