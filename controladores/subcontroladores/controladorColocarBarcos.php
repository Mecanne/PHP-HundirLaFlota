<?php

// Comprobamos si se quiere cambiar la direccion.
if (isset($_POST['cambiar-direccion'])) {
    // Comprobamos si la direccion anterior era vertical u horizontal y la cambiamos.
    if ($_POST['direccion'] == 'vertical') {
        $direccion = 'horizontal';
    } else {
        $direccion = 'vertical';
    }
} else if (isset($_POST['direccion'])) {
    $direccion = $_POST['direccion'];
} else {
    $direccion = 'vertical';
}


// Transformamos el tablero para restringir posisiones.
$arrayTableroJugador = ModeloTableros::restringirTablero($arrayTableroJugador);

// Si esta establecida una posicion significa que queremos colocar un barco.
if (isset($_POST['posicion'])) {
    // Guardamos la poscion en una variable
    $posicion = $_POST['posicion'];
    $fila = $posicion {
        0}; // Cogemos el numero
    $columna = $posicion {
        1}; // Cogemos la letra
    // Colocamos el barco en esa posicion en el tablero
    ModeloTableros::colocarBarco($fila, $columna, $direccion, $_POST['idtablero']);

    // Volvemos a cargar el tablero para guardar los cambios.
    // Dependiendo de si el jugador es el host o no, el tablero del host y el del contrincante cambiará 
    if ($host) {
        // Cogemos el tablero del host
        $arrayTableroJugador = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
    } else {
        // Cogemos el tablero del host
        $arrayTableroJugador = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
    }
    // Transformamos el tablero para restringir posisiones.
    $arrayTableroJugador = ModeloTableros::restringirTablero($arrayTableroJugador);

    // Si el barco que hemos introducido era el ultimo, 
    if (ModeloTableros::longitudSiguienteBarco($tablero['IDTablero']) == 0) {
        // Dependiendo de si eres el host de la partida o no, se le asignará un estado u otro a la partida.
        if ($host) {
            ModeloPartidas::cambiarEstadoPartida($partida['IDPartida'], 2);
        } else {
            ModeloPartidas::cambiarEstadoPartida($partida['IDPartida'], 4);
        }
        include('vistas/vistaVerPartida.php');
    } else {
        // Imprimimos cual va a ser el proximo barco a introducir.
        $longitudProximoBarco = ModeloTableros::longitudSiguienteBarco($tablero['IDTablero']);
        $nombreProximoBarco = '';

        switch ($longitudProximoBarco) {
            case 5:
                $nombreProximoBarco = 'Portaviones';
                break;
            case 4:
                $nombreProximoBarco = 'Acorazado';
                break;
            case 3:
                $nombreProximoBarco = 'Crucero';
                break;
            case 2:
                $nombreProximoBarco = 'Destructor';
                break;

            default:
                break;
}
        include('vistas/vistaColocarBarcos.php');
    }
} else {
    // Imprimimos cual va a ser el proximo barco a introducir.
    $longitudProximoBarco = ModeloTableros::longitudSiguienteBarco($tablero['IDTablero']);
    $nombreProximoBarco = '';

    switch ($longitudProximoBarco) {
        case 5:
            $nombreProximoBarco = 'Portaviones';
            break;
        case 4:
            $nombreProximoBarco = 'Acorazado';
            break;
        case 3:
            $nombreProximoBarco = 'Crucero';
            break;
        case 2:
            $nombreProximoBarco = 'Destructor';
            break;

        default:
            break;
    }
    
    include('vistas/vistaColocarBarcos.php');
}



