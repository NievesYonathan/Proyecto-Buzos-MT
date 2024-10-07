<?php
include_once "Conexion.php";

class ProFabricados{
    public function consultarPro(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT rPF.*, p.*, e.eta_nombre
        FROM reg_pro_fabricados AS rPF 
        LEFT JOIN produccion AS p ON rPF.produccion_id_produccion = p.id_produccion
        LEFT JOIN etapas AS e ON p.pro_etapa = e.id_etapas
        ";
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }

    
}