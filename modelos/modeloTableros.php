<?php

class ModeloTableros
{
    function __construct()
    {
        
    }

    static function crearTablero($IDJugador,$IDPartida){
        $conexion = ModeloBase::crearConexion('flota');
        $creado = true;
        mysqli_query($conexion,'INSERT INTO tableros (IDJugador,IDPartida) 
                                VALUES (\'' . $IDJugador . '\',\'' . $IDPartida . '\')')
            or $creado = false;

        ModeloBase::cerrarConexion($conexion);
        return $creado;
    }

    static function cargarTablero($IDPartida){

    }


}
