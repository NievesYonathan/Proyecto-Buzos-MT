<?php
include_once 'Conexion.php';

class MatProduccion{
    public function addMatProduccion($cantidadMP, $idMateriPrima, $idProduccion){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "INSERT INTO reg_pro_mat_prima(reg_pmp_cantidad_usada, reg_pmp_fecha_registro, id_pro_materia_prima, id_produccion)
        VALUE(?, ?, ?, ?)";

        $fechaAsig = date('Y-m-d');

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('isii', $cantidadMP, $fechaAsig, $idMateriPrima, $idProduccion);
        $stmt->execute();
        $conectar->close();
    }
}