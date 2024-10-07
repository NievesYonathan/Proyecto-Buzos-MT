<?php
include_once 'Conexion.php';

class Produccion {
    public function agregarProduccion($pNombre, $fInicio, $fFin, $pCantidad, $pEtapa){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = 'INSERT INTO produccion (pro_nombre, pro_fecha_inicio, pro_fecha_fin, pro_cantidad, pro_etapa) VALUES 
            (?,?,?,?,?)';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('sssii', $pNombre, $fInicio, $fFin, $pCantidad, $pEtapa);
        $stmt->execute();
        $id_produccion = $conectar->insert_id; // Obtiene el último ID insertado
        $stmt->close();
        $conectar->close();
        return $id_produccion;
    }
}