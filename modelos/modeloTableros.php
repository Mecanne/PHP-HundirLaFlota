<?php

class ModeloTableros
{
    function __construct()
    { }

    static function crearTablero($IDJugador, $IDPartida)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $creado = true;
        mysqli_query($conexion, "INSERT INTO tableros (IDJugador,IDPartida) VALUES ($IDJugador,$IDPartida)")
            or $creado = false;

        ModeloBase::cerrarConexion($conexion);
        return $creado;
    }

    static function getTablero($IDPartida, $IDJugador)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $registros = mysqli_query($conexion, 'SELECT * FROM tableros WHERE IDPartida = \'' . $IDPartida . '\' AND IDJugador = \'' . $IDJugador . '\'');
        $tablero = mysqli_fetch_array($registros);
        ModeloBase::cerrarConexion($conexion);
        return $tablero;
    }

    static function getTableroById($idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $registros = mysqli_query($conexion, 'SELECT * FROM tableros WHERE IDTablero = ' . $idtablero);
        $tablero = mysqli_fetch_array($registros);
        ModeloBase::cerrarConexion($conexion);
        return $tablero;
    }

    static function cargarTablero($IDPartida, $IDJugador)
    {
        $conexion = ModeloBase::crearConexion('flota'); // Creamos la conexion
        $tablero = ModeloTableros::getTablero($IDPartida, $IDJugador);
        $casillas = ModeloCasillas::getCasillas($tablero['IDTablero']); // Conseguimos las casillas del tablero correspondiente.
        // Creamos el array de 10 posiciones para las filas.
        $tabla = array(10);
        for ($f = 0; $f < 10; $f++) {
            // Creamos el array para las columnas de 10 posicones.
            $tabla[$f] = array(10);
            // Recorremos el array de la tabla.
            for ($c = 0; $c < 10; $c++) {
                // Cogemos la letra correspondiente a la columna.
                $columna = 'ABCDEFGHIJ' {
                    $c};
                //$tabla[$f][$c] = $c.$columna;
                if (count($casillas) > 0) {
                    $casillaEncontrada = false;
                    // Recorremos todas las casillas
                    for ($i = 0; $i < count($casillas); $i++) {
                        if ($casillas[$i]['Letra'] == $columna && $casillas[$i]['Numero'] == $f) {
                            $casillaEncontrada = true;
                            $tabla[$f][$c] = $casillas[$i]['IDEstadoCasilla'];
                            break;
                        }
                    }
                    if (!$casillaEncontrada) {
                        $tabla[$f][$c] = 0;
                    }
                } else {
                    $tabla[$f][$c] = 0;
                }
            }
        }
        ModeloBase::cerrarConexion($conexion); // Cerramos conexion
        return $tabla; // Devolvemos el array del tablero.
    }
    static function cargarTableroById($idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota'); // Creamos la conexion
        $tablero = ModeloTableros::getTableroById($idtablero);
        $casillas = ModeloCasillas::getCasillas($tablero['IDTablero']); // Conseguimos las casillas del tablero correspondiente.
        // Creamos el array de 10 posiciones para las filas.
        $tabla = array(10);
        for ($f = 0; $f < 10; $f++) {
            // Creamos el array para las columnas de 10 posicones.
            $tabla[$f] = array(10);
            // Recorremos el array de la tabla.
            for ($c = 0; $c < 10; $c++) {
                // Cogemos la letra correspondiente a la columna.
                $columna = 'ABCDEFGHIJ' {
                    $c};
                //$tabla[$f][$c] = $c.$columna;
                if (count($casillas) > 0) {
                    $casillaEncontrada = false;
                    // Recorremos todas las casillas
                    for ($i = 0; $i < count($casillas); $i++) {
                        if ($casillas[$i]['Letra'] == $columna && $casillas[$i]['Numero'] == $f) {
                            $casillaEncontrada = true;
                            $tabla[$f][$c] = $casillas[$i]['IDEstadoCasilla'];
                            break;
                        }
                    }
                    if (!$casillaEncontrada) {
                        $tabla[$f][$c] = 0;
                    }
                } else {
                    $tabla[$f][$c] = 0;
                }
            }
        }
        ModeloBase::cerrarConexion($conexion); // Cerramos conexion
        return $tabla; // Devolvemos el array del tablero.
    }

    static function colocarBarco($fila, $columna, $direccion, $idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        // Sacamos el numero de la columna
        $col = strpos('ABCDEFGHIJ', $columna);
        // Cogemos el array del tablero
        $arrayTablero = ModeloTableros::cargarTableroById($idtablero);
        $longitud = ModeloTableros::longitudSiguienteBarco($idtablero);
        $cabeBarco = true;
        // Comprobamos que el barco no se va a chocar con ningun barco en su recorrido o si cabe
        switch ($direccion) {
            case 'vertical':
                if ($fila + $longitud - 1 > 9) {
                    $cabeBarco = false;
                } else {
                    for ($i = 1; $i < $longitud; $i++) {
                        // Si estamos al final, comprobamos que hay un barco en la siguiente posicion
                        if ($i == $longitud - 1 && $fila + $i + 1 <= 9) {
                            if ($arrayTablero[$fila + $i + 1][$col] == 2) {
                                $cabeBarco = false;
                                break;
                            }
                        }
                        if ($col == 9) {
                            if($fila + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila + $i + 1][$col] == 2 ||
                                    $arrayTablero[$fila + $i + 1][$col - 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                        } else if ($col == 0) {
                            if($fila + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila + $i + 1][$col] == 2 ||
                                    $arrayTablero[$fila + $i + 1][$col + 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                        } else {
                            if($fila + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila + $i + 1][$col] == 2 ||
                                    $arrayTablero[$fila + $i + 1][$col + 1] == 2 ||
                                    $arrayTablero[$fila + $i + 1][$col - 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                        }
                        if ($arrayTablero[$fila + $i][$col] == 2) {
                            $cabeBarco = false;
                            break;
                        }
                    }
                }
                break;
            case 'horizontal':
                if ($col + $longitud - 1 > 9) {
                    $cabeBarco = false;
                } else {
                    for ($i = 1; $i < $longitud; $i++) {
                        // Si estamos al final, comprobamos que hay un barco en la siguiente posicion
                        if ($i == $longitud - 1 && $col + $i + 1 <= 9) {
                            if ($arrayTablero[$fila][$col + $i + 1] == 2) {
                                $cabeBarco = false;
                                break;
                            }
                        }
                        if ($fila == 9) {
                            if($col + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila][$col + $i + 1] == 2 ||
                                    $arrayTablero[$fila - 1][$col + $i + 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                            
                        } else if ($fila == 0) {
                            if($col + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila][$col + $i + 1] == 2 ||
                                    $arrayTablero[$fila + 1][$col + $i + 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                        } else {
                            if($col + $i + 1 <= 9){
                                if (
                                    $arrayTablero[$fila][$col + $i + 1] == 2 ||
                                    $arrayTablero[$fila - 1][$col + $i + 1] == 2 ||
                                    $arrayTablero[$fila + 1][$col + $i + 1] == 2
                                ) {
                                    $cabeBarco = false;
                                    break;
                                }
                            }
                        }

                        if ($arrayTablero[$fila][$col + $i] == 2) {
                            $cabeBarco = false;
                            break;
                        }
                    }
                }
                break;
        }
        if ($cabeBarco) {
            $nombreBarco = ModeloTableros::nombreSiguienteBarco($idtablero);
            switch ($direccion) {
                case 'vertical':
                    for ($i = 0; $i < $longitud; $i++) {
                        ModeloCasillas::insertarCasilla($fila + $i, $columna, $idtablero, $nombreBarco);
                    }
                    break;

                case 'horizontal':
                    for ($i = 0; $i < $longitud; $i++) {
                        ModeloCasillas::insertarCasilla($fila, 'ABCDEFGHIJ' {
                            $col + $i}, $idtablero, $nombreBarco);
                    }
                    break;
            }
        }
        ModeloBase::cerrarConexion($conexion);
    }

    static function longitudSiguienteBarco($idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $cantidadBarcosTablero = ModeloCasillas::sacarCantidadBarcos($idtablero);
        // Dependiendo de la cantidad de barcos que haya en el tablero, sacará 
        switch ($cantidadBarcosTablero) {
            case 0:
                return 5;
            case 5:
                return 4;
            case 9:
                return 3;
            case 12:
                return 3;
            case 15:
                return 2;
            case 17:
                return 2;
            case 19:
                return 2;
            default:
                return 0;
        }
        ModeloBase::cerrarConexion($conexion);
    }

    static function cantidadBarcosRestantes($idtablero)
    {
        // Creamos la conexion
        $conexion = ModeloBase::crearConexion('flota');
        // Realizamos una consulta de la cantidad de casillas con estado 2 en el tablero, es decir, barcos sin tocar
        $registros = mysqli_query($conexion, "SELECT COUNT(*) as cantidad
                                                FROM casillas
                                                WHERE IDEstadoCasilla = 2
                                                    AND IDTablero = $idtablero");
        // Cerramos la conexion
        ModeloBase::cerrarConexion($conexion);
        // La alamacena en una variable
        $count = mysqli_fetch_array($registros);
        echo '';
        // Devuelve la cantidad de barcos
        return $count['cantidad'];
    }

    // Funcion que transforma un tablero para restringir las posiciones 
    static function restringirTablero($tableroViejo)
    {
        $tablero = $tableroViejo;
        for ($f = 0; $f < 10; $f++) {
            for ($c = 0; $c < 10; $c++) {
                // Si estamos en la primera fila debemos comprobar solo las posiciones de abajo, izquierda y derecha.
                if ($f == 0) {
                    // Si estamos en la coluna 0, debemos comprobar solo a la derecha y abajo.
                    if ($c == 0) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                            if ($tablero[$f + 1][$c + 1] != 2) $tablero[$f + 1][$c + 1] = 1; // Abajo derecha
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                        }
                    }
                    // Si estamos en la ultima columna, solo debemos comprobar a la izquierda y abajo
                    else if ($c == 9) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                            if ($tablero[$f + 1][$c - 1] != 2) $tablero[$f + 1][$c - 1] = 1; // Abajo Izquierda
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                        }
                    }
                    // Si no debemos comprobar tanto abajo como a la derecha como a la izquierda.
                    else {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                            if ($tablero[$f + 1][$c + 1] != 2) $tablero[$f + 1][$c + 1] = 1; // Abajo derecha
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                            if ($tablero[$f + 1][$c - 1] != 2) $tablero[$f + 1][$c - 1] = 1; // Abajo Izquierda
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                        }
                    }
                }
                // Si estamos en la ultima fila, debemos comprobar tanto encima como a la izquierda y a la derecha.
                else if ($f == 9) {
                    // Si estamos en la coluna 0, debemos comprobar solo a la derecha y arriba.
                    if ($c == 0) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                            if ($tablero[$f - 1][$c + 1] != 2) $tablero[$f - 1][$c + 1] = 1; // Arriba derecha
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                        }
                    }
                    // Si estamos en la ultima columna, solo debemos comprobar a la izquierda y arriba
                    else if ($c == 9) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c - 1] = 1; // Arriba izquierda 
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                        }
                    }
                    // Si no debemos comprobar tanto encima como a la derecha como a la izquierda.
                    else {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c - 1] = 1; // Arriba izquierda 
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                            if ($tablero[$f - 1][$c + 1] != 2) $tablero[$f - 1][$c + 1] = 1; // Arriba derecha
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                        }
                    }
                }
                // Si no estamos en ningun de los bordes del tablero, debemos comprobar tanto encima como debajo
                else {
                    // Si estamos en la coluna 0, no debemos comprobar a la izquierda
                    if ($c == 0) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                            if ($tablero[$f - 1][$c + 1] != 2) $tablero[$f - 1][$c + 1] = 1; // Arriba derecha
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                            if ($tablero[$f + 1][$c + 1] != 2) $tablero[$f + 1][$c + 1] = 1; // Abajo derecha
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                        }
                    }
                    // Si estamos en la ultima columna, no debemos comprobar a la derecha
                    else if ($c == 9) {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                            if ($tablero[$f + 1][$c - 1] != 2) $tablero[$f + 1][$c - 1] = 1; // Abajo Izquierda
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c - 1] = 1; // Arriba izquierda
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                        }
                    }
                    // Si no debemos comprobar todas las posiciones
                    else {
                        if ($tablero[$f][$c] == 2) {
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c] = 1; // Arriba
                            if ($tablero[$f - 1][$c + 1] != 2) $tablero[$f - 1][$c + 1] = 1; // Arriba derecha
                            if ($tablero[$f][$c + 1] != 2) $tablero[$f][$c + 1] = 1; // Derecha
                            if ($tablero[$f + 1][$c + 1] != 2) $tablero[$f + 1][$c + 1] = 1; // Abajo derecha
                            if ($tablero[$f + 1][$c] != 2) $tablero[$f + 1][$c] = 1; // Abajo
                            if ($tablero[$f + 1][$c - 1] != 2) $tablero[$f + 1][$c - 1] = 1; // Abajo Izquierda
                            if ($tablero[$f][$c - 1] != 2) $tablero[$f][$c - 1] = 1; // Izquierda
                            if ($tablero[$f - 1][$c] != 2) $tablero[$f - 1][$c - 1] = 1; // Arriba izquierda 
                        }
                    }
                }
            }
        }

        return $tablero;
    }

    // Funcion que te da el nombre del barco dependiendo de la longitud de este
    static function nombreSiguienteBarco($idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $cantidadBarcosTablero = ModeloCasillas::sacarCantidadBarcos($idtablero);
        // Dependiendo de la cantidad de barcos que haya en el tablero, sacará 
        switch ($cantidadBarcosTablero) {
            case 0:
                return 'Portaviones';
            case 5:
                return 'Acorazado';
            case 9:
                return 'Crucero1';
            case 12:
                return 'Crucero2';
            case 15:
                return 'Destructor1';
            case 17:
                return 'Destructor2';
            case 19:
                return 'Destructor3';
            default:
                return '';
        }
        ModeloBase::cerrarConexion($conexion);
    }
}
