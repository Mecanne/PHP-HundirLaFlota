<?php

// Cogemos la partida
$partida = ModeloPartidas::getPartida($_POST['idpartida']);

// Comprobamos si el jugador es el host de la partida y los almacenamos en la variable host.
$host = $usuario['IDJugador'] == $partida['IDHost'];

// Cogemos el id del tablero para poder usarlo de nuevo.
$tablero = ModeloTableros::getTablero($partida['IDPartida'], $usuario['IDJugador']);
// Dependiendo de si el jugador es el host o no, el tablero del host y el del contrincante cambiará 
if ($host) {
    // Cogemos array del tablero del host
    $arrayTableroJugador = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
    // Cogemos array del tablero del contrincante.
    $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
    // Cogemos el tablero del contrincante
    $tableroContrincante = ModeloTableros::getTablero($partida['IDPartida'], $partida['IDContrincante']);
} else {
    // Cogemos el tablero del host
    $arrayTableroJugador = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
    // Cogemos el tablero del contrincante.
    $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
    // Cogemos el tablero del contrincante
    $tableroContrincante = ModeloTableros::getTablero($partida['IDPartida'], $partida['IDHost']);
}

// Comprobamos si es el host, y dependiendo de ello, sabremos cuando debe jugar el
if ($host) {
    switch ($partida['IDEstadoPartida']) {
        case 1:
            include('controladores/subcontroladores/controladorColocarBarcos.php');
            break;
        case 4:
            include('controladores/subcontroladores/controladorDisparar.php');
            break;
        case 6:
            include('vistas/vistaPartidaFinalizada.php');
            break;
        default:
            include('controladores/subcontroladores/controladorVerPartida.php');
    }
} else {
    switch ($partida['IDEstadoPartida']) {
        case 2:
            include('controladores/subcontroladores/controladorColocarBarcos.php');
            break;
        case 5:
            include('controladores/subcontroladores/controladorDisparar.php');
            break;
        case 6:
            include('vistas/vistaPartidaFinalizada.php');
            break;
        default:
            include('controladores/subcontroladores/controladorVerPartida.php');
    }
}

