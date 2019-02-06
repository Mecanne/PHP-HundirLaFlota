<?php
//Creamos la partida
$partidaCreada = ModeloPartidas::crearPartida($usuario['IDJugador']);
include('controladores/subcontroladores/controladorPartidas.php');
unset($_POST['crear']);