<?php
include 'Conexion.php';

class ModeloTarea {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectarse();
    }

    public function crearTarea($nombreTarea, $descripcionTarea, $estadoTarea, $fechaAsignacion, $fechaEntrega, $empleadosNumDoc, $produccionId) {

        $queryTarea = "INSERT INTO tarea (tar_nombre, tar_descripcion, tar_estado) VALUES (?, ?, ?)";
        $stmtTarea = $this->conexion->prepare($queryTarea);
        $stmtTarea->bind_param("ssi", $nombreTarea, $descripcionTarea, $estadoTarea);
        $stmtTarea->execute();

        $tareaId = $this->conexion->insert_id;

        $queryEmpTarea = "INSERT INTO emp_tarea (empleados_num_doc, tarea_id_tarea, emp_tar_fecha_asignacion, emp_tar_fecha_entrega, emp_tar_estado_tarea, produccion_id_produccion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtEmpTarea = $this->conexion->prepare($queryEmpTarea);
        $stmtEmpTarea->bind_param("iisssi", $empleadosNumDoc, $tareaId, $fechaAsignacion, $fechaEntrega, $estadoTarea, $produccionId);
        return $stmtEmpTarea->execute();
    }

    public function obtenerEstados() {
        $sql = "SELECT id_estados, nombre_estado FROM estados WHERE id_estados NOT IN (1, 2)";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerOperarios() {
        $sql = "SELECT num_doc, usu_nombres, usu_apellidos FROM usuarios
                INNER JOIN cargos_has_usuarios ON usuarios.num_doc = cargos_has_usuarios.usuarios_num_doc
                WHERE cargos_has_usuarios.cargos_id_cargos = 3";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerProducciones() {
        $sql = "SELECT id_produccion, pro_nombre FROM produccion";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTareas() {
        $sql = "SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, e.nombre_estado,
                    emp.emp_tar_fecha_asignacion, emp.emp_tar_fecha_entrega, emp.produccion_id_produccion
                FROM tarea t
                LEFT JOIN emp_tarea emp ON t.id_tarea = emp.tarea_id_tarea
                LEFT JOIN estados e ON t.tar_estado = e.id_estados";
        $result = $this->conexion->query($sql);
    
        if (!$result) {
            die('Error en la consulta: ' . $this->conexion->error);
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTareasPorOperario($num_doc) {
        $sql = "
            SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, e.nombre_estado,
            emp.emp_tar_fecha_asignacion, emp.emp_tar_fecha_entrega, emp.produccion_id_produccion
            FROM tarea t
            LEFT JOIN emp_tarea emp ON t.id_tarea = emp.tarea_id_tarea
            LEFT JOIN estados e ON t.tar_estado = e.id_estados
            WHERE emp.empleados_num_doc = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $num_doc);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function actualizarTarea($idTarea, $nombre, $descripcion, $estado, $fechaAsignacion, $fechaEntrega, $empleadosNumDoc, $produccionId) {
        // Actualiza la tabla tarea
        $query = "UPDATE tarea SET tar_nombre=?, tar_descripcion=?, tar_estado=? WHERE id_tarea=?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ssii", $nombre, $descripcion, $estado, $idTarea);
        $resultado = $stmt->execute();
    
        // Actualiza también la tabla emp_tarea
        $queryEmpTarea = "UPDATE emp_tarea SET emp_tar_fecha_asignacion=?, emp_tar_fecha_entrega=?, empleados_num_doc=?, produccion_id_produccion=? WHERE tarea_id_tarea=?";
        $stmtEmpTarea = $this->conexion->prepare($queryEmpTarea);
        $stmtEmpTarea->bind_param("sssii", $fechaAsignacion, $fechaEntrega, $empleadosNumDoc, $produccionId, $idTarea);
        $resultadoEmpTarea = $stmtEmpTarea->execute();
    
        return $resultado && $resultadoEmpTarea;
    }

    public function obtenerTareaPorId($idTarea) {
        $query = "SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, t.tar_estado,
                    e.nombre_estado, emp.empleados_num_doc, emp.emp_tar_fecha_asignacion,
                    emp.emp_tar_fecha_entrega, emp.produccion_id_produccion,
                    u.usu_nombres, u.usu_apellidos, p.pro_nombre
                    FROM tarea t
                    LEFT JOIN emp_tarea emp ON t.id_tarea = emp.tarea_id_tarea
                    LEFT JOIN estados e ON t.tar_estado = e.id_estados
                    LEFT JOIN usuarios u ON emp.empleados_num_doc = u.num_doc
                    LEFT JOIN produccion p ON emp.produccion_id_produccion = p.id_produccion
                    WHERE t.id_tarea = ?";
    
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $idTarea);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }

    public function buscarTarea($busqueda) {
        $query = "
            SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, emp.emp_tar_fecha_entrega AS fecha_entrega, e.nombre_estado 
            FROM tarea t
            LEFT JOIN emp_tarea emp ON t.id_tarea = emp.tarea_id_tarea
            LEFT JOIN estados e ON t.tar_estado = e.id_estados
            WHERE t.tar_nombre LIKE '%$busqueda%'
        ";

        return $this->conexion->query($query);
    }


public function actualizarEstadoTarea($idTarea, $nuevoEstado) {
    $query = "UPDATE tarea SET tar_estado = ? WHERE id_tarea = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("ii", $nuevoEstado, $idTarea);
    return $stmt->execute();
}
}
?>
