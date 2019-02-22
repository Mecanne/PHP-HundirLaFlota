<?php

class ModeloCasillas
{
    function __construct()
    {
    }

    // Funcion que te devuelve todas las casillas de un tablero
    static function getCasillas($IDTablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $casillas = array();
        $registros = mysqli_query($conexion, 'SELECT * FROM casillas WHERE IDTablero = ' . $IDTablero);
        while ($casilla = mysqli_fetch_array($registros)) {
            $casillas[] = $casilla;
        }
        ModeloBase::cerrarConexion($conexion);
        return $casillas;
    }

    // Funcion que cambia el estado de una casilla
    static function setEstadoCasilla($fila, $columna, $idtablero, $estado)
    {
        $conexion = ModeloBase::crearConexion('flota');
        mysqli_query($conexion, "UPDATE casillas
                                SET IDEstadoCasilla = " . $estado . "
                                WHERE IDTablero = " . $idtablero . " AND Letra = '$columna' AND Numero = $fila");
        ModeloBase::cerrarConexion($conexion);
    }

    // Funcion que devuelve el estado de una casilla
    static function getEstadoCasilla($fila, $columna, $idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $registros = mysqli_query($conexion, "SELECT IDEstadoCasilla
                                                FROM casillas
                                                WHERE IDTablero = " . $idtablero . " AND Letra = '$columna' AND Numero = $fila");
        ModeloBase::cerrarConexion($conexion);
        if ($estado = mysqli_fetch_array($registros)) {
            return $estado['IDEstadoCasilla'];
        }
        return 0;
    }

    // Funcion que inserta una casilla, si no se le pasa ningun estado como parametro, sera 2 por defecto, que queiere decir que es un barco
    static function insertarCasilla($fila, $columna, $idtablero, $nombre, $estado = 2)
    {
        $conexion = ModeloBase::crearConexion('flota');
        mysqli_query($conexion, "INSERT INTO casillas(Letra,Numero,IDTablero,IDEstadoCasilla,NombreBarco) VALUES ('$columna',$fila,$idtablero,$estado,'$nombre')");
        ModeloBase::cerrarConexion($conexion);
    }

    static function sacarCantidadBarcos($idtablero)
    {
        $conexion = ModeloBase::crearConexion('flota');
        // Consultamos cuantas casilla con el estado de barco quedan en ese tablero
        $registros = mysqli_query($conexion, "SELECT COUNT(*) as cantidad
                                                FROM casillas
                                                WHERE IDEstadoCasilla = 2 AND IDTablero = " . $idtablero);
        ModeloBase::cerrarConexion($conexion);
        return mysqli_fetch_array($registros)['cantidad'];
    }

    static function comprobarBarcoHundido($fila, $columna, $IDTablero)
    {
        // Creamos la conexion
        $conexion = ModeloBase::crearConexion('flota');
        // Primero tenemos que saber el nombre identificador del barco en esa fila y columna de ese tablero.
        $registrosNombreBarco = mysqli_query($conexion, "SELECT NombreBarco
                                                    FROM casillas
                                                    WHERE Numero = $fila
                                                        AND Letra = '$columna'
                                                        AND IDTablero = $IDTablero");
        
        $nombreBarco = mysqli_fetch_array($registrosNombreBarco)['NombreBarco'];
        // Hacemos una consulta para saber todos los barco que tienen ese nombre en el tablero
        $registrosBarco = mysqli_query($conexion, "SELECT *
                                                    FROM casillas
                                                    WHERE IDTablero = $IDTablero
                                                        AND NombreBarco LIKE '%$nombreBarco%'");
        // Cerramos la conexion
        ModeloBase::cerrarConexion($conexion);
        // Recorremos toda la tabla 
        while ($reg = mysqli_fetch_array($registrosBarco)) {
            // Si el estado de la casilla coincide con que es 2, es que hay un barco, por lo uqe devolvemos false
            if ($reg['IDEstadoCasilla'] == 2) return false;
        }
        // Si no hay ningun barco con estado 2, es que el barco esta hundido, por lo que devolvemos true.
        return true;
    }

}