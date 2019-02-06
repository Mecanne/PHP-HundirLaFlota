<?php

class ModeloPartidas
{

    function __construct()
    {
    }

    static function crearPartida($idHost)
    {
        $conexion = ModeloBase::crearConexion("flota");
        $creada = true;
        $registros = mysqli_query($conexion, 'SELECT COUNT(*) as \'Cantidad\' FROM Partidas WHERE IDHost = \'' . $idHost . '\' AND IDEstadoPartida = 1');
        $cantidad_de_partidas = mysqli_fetch_array($registros)['Cantidad'];
        echo '<script>console.log("' . $cantidad_de_partidas . '")</script>';
        if ($cantidad_de_partidas < 3) {
            mysqli_query($conexion, "INSERT INTO partidas(IDHost,IDEstadoPartida) VALUES('" . $idHost . "','1')")
                or $creada = false;
            ModeloBase::cerrarConexion($conexion);
        } else {
            $creada = false;
        }
        return $creada;
    }

    static function borrarPartida($idPartida)
    {
        $conexion = ModeloBase::crearConexion("flota");
        $borrada = true;
        mysqli_query($conexion, "DELETE FROM partidas WHERE IDPartida = '" . $idPartida . "'")
            or $borrada = false;
        ModeloBase::cerrarConexion($conexion);
        return $borrada;
    }

    static function listarPartidasDisponibles($idHost)
    {
        /**
         * La lista de partidas disponibles son las siguientes:
         *  - Partidas que tengan el estado 1, 3 y 4 siendo el host
         *  - Partidas que tengan el estado 2 y 5 siendo el contrincante.
         */
        // Creamos la conexion a la base de datos
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos todas las partidas que tiene ese jugador.
        $registros = mysqli_query($conexion, "SELECT IDPartida, jh.Usuario as 'Host', jc.Usuario as 'Contrincante', descripcion as Descripcion
                                                FROM partidas
                                                LEFT JOIN jugadores jh ON partidas.IDHost = jh.IDJugador
                                                LEFT JOIN jugadores jc ON partidas.IDContrincante = jc.IDJugador
                                                LEFT JOIN estadosPartida ON partidas.IDEstadoPartida = estadosPartida.IDEstadoPartida
                                                WHERE (jh.IDJugador = " . $idHost . " AND 
                                                            (partidas.IDEstadoPartida = 1 
                                                            OR partidas.IDEstadoPartida = 3 
                                                            OR partidas.IDEstadoPartida = 4))
                                                    OR (jc.IDJugador = " . $idHost . " AND 
                                                            (partidas.IDEstadoPartida = 2 
                                                            OR partidas.IDEstadoPartida = 5))");
        // Creamos el array que contendrá las partidas que tiene el jugador.
        $partidas = array();
        // Mientras haya paertias en la consulta, se las añadiremos al array.
        while ($reg = mysqli_fetch_row($registros)) {
            $partidas[] = $reg;
        }
        // Cerramos la conexion.
        ModeloBase::cerrarConexion($conexion);
        // Devolvemos las partidas.
        return $partidas;
    }

    static function listarPartidasEnEspera($idHost)
    {
        /**
         * La lista de partidas en espera son las siguientes:
         *  - Partidas que tengan el estado 2 y 5, en las que hay que esperar a que juegue el contrincante.
         */
        // Creamos la conexion a la base de datos
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos todas las partidas que tiene ese jugador.
        $registros = mysqli_query($conexion, "SELECT IDPartida, jh.Usuario as 'Host', jc.Usuario as 'Contrincante', descripcion as Descripcion
                                                FROM partidas
                                                LEFT JOIN jugadores jh ON partidas.IDHost = jh.IDJugador
                                                LEFT JOIN jugadores jc ON partidas.IDContrincante = jc.IDJugador
                                                LEFT JOIN estadosPartida ON partidas.IDEstadoPartida = estadosPartida.IDEstadoPartida
                                                WHERE (jh.IDJugador = " . $idHost . " AND 
                                                            (partidas.IDEstadoPartida = 2 
                                                            OR partidas.IDEstadoPartida = 5))
                                                    OR (jc.IDJugador = " . $idHost . " AND 
                                                            (partidas.IDEstadoPartida = 1 
                                                            OR partidas.IDEstadoPartida = 3
                                                            OR partidas.IDEstadoPartida = 4))");
        // Creamos el array que contendrá las partidas que tiene el jugador.
        $partidas = array();
        // Mientras haya paertias en la consulta, se las añadiremos al array.
        while ($reg = mysqli_fetch_row($registros)) {
            $partidas[] = $reg;
        }
        // Cerramos la conexion.
        ModeloBase::cerrarConexion($conexion);
        // Devolvemos las partidas.
        return $partidas;
    }

    static function listarPartidasAcabadas($idHost)
    {
        // Creamos la conexion a la base de datos
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos todas las partidas que tiene ese jugador.
        $registros = mysqli_query($conexion, "SELECT IDPartida, jh.Usuario as 'Host', jc.Usuario as 'Contrincante', descripcion as Descripcion
                                                FROM partidas
                                                LEFT JOIN jugadores jh ON partidas.IDHost = jh.IDJugador
                                                LEFT JOIN jugadores jc ON partidas.IDContrincante = jc.IDJugador
                                                LEFT JOIN estadosPartida ON partidas.IDEstadoPartida = estadosPartida.IDEstadoPartida
                                                WHERE (jh.IDJugador = '" . $idHost . "'
                                                    AND partidas.IDEstadoPartida = 6)
                                                OR (jc.IDJugador = '" . $idHost . "'
                                                    AND partidas.IDEstadoPartida = 6)");
        // Creamos el array que contendrá las partidas que tiene el jugador.
        $partidas = array();
        // Mientras haya paertias en la consulta, se las añadiremos al array.
        while ($reg = mysqli_fetch_row($registros)) {
            $partidas[] = $reg;
        }
        // Cerramos la conexion.
        ModeloBase::cerrarConexion($conexion);
        // Devolvemos las partidas.
        return $partidas;
    }

    static function getEstadoPartida($IDPartida)
    {
        $conexion = ModeloBase::crearConexion("flota");
        $registros = mysqli_query($conexion, "SELECT Descripcion FROM estadospartida e, partidas p WHERE p.IDEstadoPartida = e.IDEstadoPartida AND p.IDPartida = '" . $IDPartida . "'");
        $estado = mysqli_fetch_array($registros)['Descripcion'];
        ModeloBase::cerrarConexion($conexion);
        return $estado;
    }

    static function comprobarPartida($IDPartida)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $partidas = mysqli_query($conexion, "SELECT * FROM Partidas WHERE IDPartida = '" . $IDPartida . "'");
        ModeloBase::cerrarConexion($conexion);
        if ($partida = mysqli_fetch_array($partidas)) {
            return true;
        } else {
            return false;
        }

    }

    static function comprobarContrincantePartida($IDPartida)
    {
        $conexion = ModeloBase::crearConexion('flota');
        $partidas = mysqli_query($conexion, "SELECT * 
                                            FROM Partidas 
                                            WHERE IDPartida = '" . $IDPartida . "' 
                                                AND IDContrincante IS NULL");
        ModeloBase::cerrarConexion($conexion);
        if ($partida = mysqli_fetch_array($partidas)) {
            return true;
        } else {
            return false;
        }

    }

    static function asignarContrincante($IDPartida, $IDContrincante)
    {
        $conexion = ModeloBase::crearConexion("flota");
        if(ModeloPartidas::comprobarContrincantePartida($IDPartida)){
            mysqli_query($conexion, "UPDATE partidas
                                    SET IDContrincante = '" . $IDContrincante . "'
                                    WHERE IDPartida = '" . $IDPartida . "'");
            ModeloBase::cerrarConexion($conexion);
            return true;
        }
        ModeloBase::cerrarConexion($conexion);
        return false;
    }

}