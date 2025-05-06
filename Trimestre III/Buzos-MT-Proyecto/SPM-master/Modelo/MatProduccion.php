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

    public function editMatProduccion($cantidadMP, $idMateriPrima, $idProduccion, $idRegistro){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "UPDATE reg_pro_mat_prima SET reg_pmp_cantidad_usada = ?, reg_pmp_fecha_registro = ?, id_pro_materia_prima = ? WHERE id_produccion = ? AND id_registro = ?";

        $fechaAsig = date('Y-m-d');

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('isiii', $cantidadMP, $fechaAsig, $idMateriPrima, $idProduccion, $idRegistro);
        $stmt->execute();
        $conectar->close();
    }

    public function getMatProduccionId($idProduccion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT id_pro_materia_prima FROM reg_pro_mat_prima WHERE id_produccion = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('i', $idProduccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conectar->close();
        return $result;
    }

}