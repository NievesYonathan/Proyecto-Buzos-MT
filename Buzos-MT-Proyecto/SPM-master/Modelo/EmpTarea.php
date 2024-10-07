<?php
include_once 'Conexion.php';

class EmpTarea{
    public function addTareaProd($numDoc, $tareaId, $fAsignacion, $fEntrega, $idEstado, $idProduccion){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "INSERT INTO emp_tarea(empleados_num_doc, tarea_id_tarea, emp_tar_fecha_asignacion, emp_tar_fecha_entrega, emp_tar_estado_tarea, produccion_id_produccion)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('iissii', $numDoc, $tareaId, $fAsignacion, $fEntrega, $idEstado, $idProduccion);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }
}