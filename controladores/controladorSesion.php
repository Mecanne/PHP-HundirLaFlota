<?php
$usuario = ModeloJugador::getJugador($_SESSION['usuario']);
if (isset($_POST['crear'])) {
    include('controladores/subcontroladores/controladorCrearPartida.php');
} else if (isset($_POST['unirse'])) {
    include('controladores/subcontroladores/controladorUnirseNuevaPartida.php');
} else if (isset($_POST['lista'])) {
    include('controladores/subcontroladores/controladorPartidas.php');
} else if (isset($_POST['jugar-partida'])) {
    include('controladores/subcontroladores/controladorJugarPartida.php');
} else if (isset($_POST['borrar-partida'])) {
    include('controladores/subcontroladores/controladorBorrarPartida.php');
}  else if (isset($_POST['salir'])) {
    session_unset();
    $_SESSION = array();
    session_destroy();
    unset($_POST['salir']);
    include("vistas/vistaLogin.php");
} else {
    include("vistas/vistaMenu.php");
}