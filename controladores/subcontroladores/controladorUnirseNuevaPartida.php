<?php
// Comprobamos ha solicitado unirse a una partida.
if (isset($_POST['IDPartida'])) {
    // Si es asi, asignaremos el contricante a la partida y incluiremos la vista de las partidas.
    ModeloPartidas::asignarContrincante($_POST['IDPartida'], $usuario['IDJugador']);
    include('controladores/subcontroladores/controladorPartidas.php');
} else {
    // Si no, mostraremos las partidas disponibles.
    $partidasDisponibles = ModeloPartidas::listarPartidasPosibles($usuario['IDJugador']);
    include("vistas/vistaUnirsePartida.php");
}