<?php
require_once 'mysql.php';
class crud
{
    public static function Create($query)
    {
        $conexion = new mysql();
        $consulta = mysqli_query($conexion->Conexion(), $query);
        return $consulta;
    }

    public static function Read($query)
    {
        $conexion = new mysql();
        $consulta = mysqli_query($conexion->Conexion(), $query);
        return $consulta;
    }

    public static function Update($query)
    {
        $conexion = new mysql();
        $consulta = mysqli_query($conexion->Conexion(), $query);
        return $consulta;
    }

    public static function Delete($query)
    {
        $conexion = new mysql();
        $consulta = mysqli_query($conexion->Conexion(), $query);
        return $consulta;
    }
}
