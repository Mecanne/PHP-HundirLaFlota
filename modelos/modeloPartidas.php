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

        } else {
            $creada = false;
        }
        if ($creada) {
            $registros = mysqli_query($conexion, 'SELECT MAX(IDPartida) as IDPartida FROM partidas WHERE IDHost = ' . $idHost);
            $partida = mysqli_fetch_array($registros);
            $creada = ModeloTableros::crearTablero($idHost, $partida['IDPartida']);
        }
        ModeloBase::cerrarConexion($conexion);
        return $creada;
    }

    static function cambiarEstadoPartida($idpartida,$estado){
        $conexion = ModeloBase::crearConexion('flota');
        mysqli_query($conexion,'UPDATE partidas
                                SET IDEstadoPartida = ' . $estado . '
                                WHERE IDPartida = ' .$idpartida);
        ModeloBase::cerrarConexion($conexion);
    }

    static function getPartida($idPartida)
    {
        $conexion = ModeloBase::crearConexion("flota");
        $registros = mysqli_query($conexion, "SELECT * FROM partidas WHERE IDPartida = '" . $idPartida . "'");
        if ($partida = mysqli_fetch_array($registros)) {
            ModeloBase::cerrarConexion($conexion);
            return $partida;
        }
        ModeloBase::cerrarConexion($conexion);
        return false;
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

    // Partidas a las que puedes unirte
    static function listarPartidasPosibles($idHost)
    {
        // Creamos la conexion a la base de datos
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos todas las partidas a las que puede unirse el jugador.
        $registros = mysqli_query($conexion, "SELECT IDPartida, jh.Usuario as 'Host'
                                                FROM partidas
                                                LEFT JOIN jugadores jh ON partidas.IDHost = jh.IDJugador
                                                WHERE partidas.IDContrincante IS NULL
                                                    AND partidas.IDHost <>" . $idHost);
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

    // Partidas donde es tu turno
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

    // Partidas donde es el turno del contrincante
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

    // Partidas finalizadas
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

    // Asignar un contrincante a una partida.
    static function asignarContrincante($IDPartida, $IDContrincante)
    {
        $conexion = ModeloBase::crearConexion("flota");
        mysqli_query($conexion, "UPDATE partidas
                                SET IDContrincante = '" . $IDContrincante . "'
                                WHERE IDPartida = '" . $IDPartida . "'");
        ModeloBase::cerrarConexion($conexion);
        ModeloTableros::crearTablero($IDContrincante,$IDPartida);
        return true;
    }

}