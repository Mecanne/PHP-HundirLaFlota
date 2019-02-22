<?php

// Si esta establecida una posicion significa que queremos disparar.
if(isset($_POST['posicionDisparo'])){
    // Guardamos la posicion en una variable
    $posicion = $_POST['posicionDisparo'];
    $fila = $posicion{0}; // Cogemos el numero
    $columna = $posicion{1}; // Cogemos la letra

    // Si el estado de la casilla es distinto a 0, es que la casilla existe, por lo cual, hay un barco.
    if(ModeloCasillas::getEstadoCasilla($fila,$columna,$tableroContrincante['IDTablero']) != 0){

        $tocado = true;
        // Cambiamos el estado de la casilla a 4, que significa barco atacado.
        ModeloCasillas::setEstadoCasilla($fila,$columna,$tableroContrincante['IDTablero'],4);
        // Cargamos de nuevo el tablero del contrincate para visualizar los cambios
        if($host){
            $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
        }else{
            $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
        }

        if(ModeloCasillas::comprobarBarcoHundido($fila,$columna,$tableroContrincante['IDTablero'])){
            $mensajeDisparo = 'Has <strong>hundido</strong> un barco';
        }else{
            $mensajeDisparo = 'Has <strong>tocado</strong> un barco';
        }

        // Comprobamos si le quedan barcos sin tocar al usuario
        if(ModeloTableros::cantidadBarcosRestantes($tableroContrincante['IDTablero']) > 0){
            // Si le queda al menos 1, mostrará la vista para poder seguir disparando
            include('vistas/vistaDisparar.php');
        }else{
            // Cambiamos el estado de la partida a 6, que significa que esta finalizada.
            ModeloPartidas::cambiarEstadoPartida($partida['IDPartida'],6);
            include('vistas/vistaPartidaFinalizada.php');
        }
        
    }
    // Si la casilla no existe, creamos la casilla para simbolizar el agua tocada y cambiamos el turno dependiendo de si somos el host o no.
    else{
        $mensajeDisparo = 'Has disparado al agua';

        // Insertamos la casilla y le establecemos el estado a 3, que significa que el disparo a impactado en el agua.
        ModeloCasillas::insertarCasilla($fila,$columna,$tableroContrincante['IDTablero'],'',3);
        // Cargamos de nuevo el tablero del contrincate para visualizar los cambios
        if($host){
            $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
        }else{
            $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
        }
        // Cambiamos el estado de la partida.
        if($host){
            ModeloPartidas::cambiarEstadoPartida($partida['IDPartida'],5);
        }else{
            ModeloPartidas::cambiarEstadoPartida($partida['IDPartida'],4);
        }
        include('vistas/vistaVerPartida.php');
    }
    unset($_POST['posicionDisparo']);
}else{
    // Cargamos de nuevo el tablero del contrincate para visualizar los cambios
    if($host){
        $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDContrincante']);
    }else{
        $arrayTableroContrincante = ModeloTableros::cargarTablero($partida['IDPartida'], $partida['IDHost']);
    }
    include('vistas/vistaDisparar.php');
}
