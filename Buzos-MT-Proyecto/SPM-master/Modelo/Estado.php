<?php
include_once 'Conexion.php';
class Estado {
    public function ConsultarEstados(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM estados';
        $result = mysqli_query($conectar,$sql);
        return $result;
    }
}
