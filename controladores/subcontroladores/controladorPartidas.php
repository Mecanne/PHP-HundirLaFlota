<?php
$partidasDisponibles = ModeloPartidas::listarPartidasDisponibles($usuario['IDJugador']);
$partidasEnEspera = ModeloPartidas::listarPartidasEnEspera($usuario['IDJugador']);
$partidasAcabadas = ModeloPartidas::listarPartidasAcabadas($usuario['IDJugador']);
include("vistas/vistaPartidas.php");
unset($_POST['lista']);