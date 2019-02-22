<?php

class ModeloJugador
{

    function __construct()
    {
    }

    static function registrarJugador($usuario, $contraseña)
    {
        // Creamos la conexion
        $conexion = ModeloBase::crearConexion("flota");

        $usuarios = mysqli_query($conexion,'SELECT * FROM Jugadores WHERE Usuario = \'' . $usuario . '\'');
        if($reg = mysqli_fetch_array($usuarios)){
            return false;
        }
        $registro = true;

        mysqli_query($conexion, "INSERT INTO jugadores (Usuario,Password) 
                                    VALUES ('" . $usuario . "','" . md5($contraseña) . "')")
            or $registro = false;
        
        // Cerramos conexion.
        ModeloBase::cerrarConexion($conexion);

        return $registro;
    }

    static function comprobarJugador($usuario, $contraseña)
    {
        $conexion = ModeloBase::crearConexion("flota");
        // Hacemos la consulta para ver si existe el usuario registrado.
        $registros = mysqli_query($conexion, "SELECT Usuario 
                                                FROM jugadores 
                                                WHERE Usuario = '" . $usuario . "' AND Password = '" . md5($contraseña) . "'");
        if ($reg = mysqli_fetch_array($registros)) {
            return true;
        } else {
            return false;
        }
        ModeloBase::cerrarConexion($conexion);
    }

    static function getJugador($usuario)
    {
        // Creamos la conexion
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos los datos del usuario
        $usuario = mysqli_query($conexion, "SELECT * FROM jugadores WHERE Usuario = '" . $usuario . "'");
        // Almacenamos los datos del usuario en un array.
        $arrayUsuario = mysqli_fetch_array($usuario);
        // Cerramos la conexion y retornamos el array del usuario.
        ModeloBase::cerrarConexion($conexion);
        return $arrayUsuario;
    }

    static function getJugadorById($idjugador)
    {
        // Creamos la conexion
        $conexion = ModeloBase::crearConexion("flota");
        // Recogemos los datos del usuario
        $usuario = mysqli_query($conexion, "SELECT * FROM jugadores WHERE IDJugador = '" . $idjugador . "'");
        // Almacenamos los datos del usuario en un array.
        $arrayUsuario = mysqli_fetch_array($usuario);
        // Cerramos la conexion y retornamos el array del usuario.
        ModeloBase::cerrarConexion($conexion);
        return $arrayUsuario;
    }
}

?>