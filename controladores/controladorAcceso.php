<?php
// Comprobamos si se ha querido iniciar sesion
if (isset($_POST['acceso'])) {
    // Comprobamos si existe el usuario.
    if (ModeloJugador::comprobarJugador($_POST['usuario'], $_POST['contraseña'])) {
        // Si existe creamos la sesion y despues mostramos la vista del menu.
        $_SESSION['usuario'] = $_POST['usuario'];
        $_POST = array();
        include("vistas/vistaMenu.php");
    } else {
        include("vistas/vistaLogin.php");
    }
} // Si no, comprobamos si se quiere registrar el usuario.
else if (isset($_POST['registro'])) {

    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $registrado = false;

    if ($usuario != "" && $contraseña != "") {
        $registrado = ModeloJugador::registrarJugador($usuario, $contraseña);
    }

    include("vistas/vistaLogin.php");
} // Si no, mostramos la vista de 
else {
    include("vistas/vistaLogin.php");
}