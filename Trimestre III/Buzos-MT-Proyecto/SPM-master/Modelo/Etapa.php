<?php
include_once '../Modelo/Conexion.php';

class Etapa{
    public function consultarEtapas(){
        $conexion = new Conexion();
        $conectarse = $conexion->conectarse();
        
        $sql = "SELECT * FROM etapas";
        $res = $conectarse->query($sql);
        $conectarse->close();

        return $res;
    }
}
