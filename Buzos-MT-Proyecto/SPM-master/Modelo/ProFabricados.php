<?php
include_once "Conexion.php";

class ProFabricados{
    public function consultarPro(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT rPF.*, p.*, e.eta_nombre, mp.*, rMP.*, eT.*
        FROM reg_pro_fabricados AS rPF 
        LEFT JOIN produccion AS p ON rPF.produccion_id_produccion = p.id_produccion
        LEFT JOIN etapas AS e ON p.pro_etapa = e.id_etapas
        LEFT JOIN reg_pro_mat_prima AS rMP ON p.id_produccion = rMP.id_produccion
        LEFT JOIN materia_prima AS mp ON rMP.id_pro_materia_prima = mp.id_materia_prima
        LEFT JOIN emp_tarea AS eT ON p.id_produccion = eT.produccion_id_produccion
        LEFT JOIN tarea AS t ON eT.tarea_id_tarea = t.id_tarea
        ";
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }

    
}