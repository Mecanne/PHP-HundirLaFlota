<?php

class ModeloBase
{
    function __construct()
    {
    }
    
    static function crearConexion($base)
    {
        $conexion = mysqli_connect("localhost", "root", "", $base)
            or $conexion = false;
        return $conexion;
    }

    static function cerrarConexion($conexion)
    {
        mysqli_close($conexion);
    }
}

?>