<?php
session_start();
include("modelos/modeloBase.php");
include("modelos/modeloPartidas.php");
include("modelos/modeloJugadores.php");

// Comprobamos si hay iniciada una sesion
if (isset($_SESSION['usuario'])) {
    include("controladores/controladorSesion.php");
} // Si no hay ninguna sesion iniciada, comprobamos si se quiere iniciar sesion, crear un usuario o solo mostrar el formulario.
else {
    include("controladores/controladorAcceso.php");
}
?>