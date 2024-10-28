<?php
include_once 'Conexion.php';

class EmpTarea
{
    public function addTareaProd($numDoc, $tareaId, $fAsignacion, $fEntrega, $idEstado, $idProduccion)
    {
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

    public function editarTareaProd($numDoc, $tareaId, $fEntrega, $idEmpTarea)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "UPDATE emp_tarea SET empleados_num_doc = ?, tarea_id_tarea = ?, emp_tar_fecha_entrega = ? WHERE id_empleado_tarea = ?";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('iisi', $numDoc, $tareaId, $fEntrega, $idEmpTarea);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

    public function tareasProduccion($id_produccion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT p.id_produccion, GROUP_CONCAT(eT.id_empleado_tarea) AS idEmpTarea, GROUP_CONCAT(eT.tarea_id_tarea) AS id_tarea, GROUP_CONCAT(eT.empleados_num_doc) AS operario, GROUP_CONCAT(eT.emp_tar_fecha_entrega) AS fecha_entrega FROM produccion p 
        INNER JOIN emp_tarea eT ON p.id_produccion = eT.produccion_id_produccion WHERE p.id_produccion = ?
        GROUP BY p.id_produccion';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('i', $id_produccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conectar->close();
        return $result;
    }

    public function tareasProduccionId($id_produccion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT eT.tarea_id_tarea FROM  emp_tarea eT
        INNER JOIN produccion p ON p.id_produccion = eT.produccion_id_produccion WHERE p.id_produccion = ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('i', $id_produccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conectar->close();
        return $result;
    }

    public function verificarTareaExistente($numDoc, $tareaId, $idProduccion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT id_empleado_tarea FROM emp_tarea WHERE empleados_num_doc = ? AND tarea_id_tarea = ? AND produccion_id_produccion = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('iii', $numDoc, $tareaId, $idProduccion);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica si la consulta devolvió algún resultado
        $exists = $result->num_rows > 0;

        // Cierra las conexiones y devuelve el resultado
        $stmt->close();
        $conectar->close();

        return $exists; // Retorna true si existe, false si no existe
    }
}
