<?php
class Conexion {
    public function conectarse() {
        $conexion = mysqli_connect("localhost", "root", "", "pro_buzos_mt");
        return $conexion;
    }
}