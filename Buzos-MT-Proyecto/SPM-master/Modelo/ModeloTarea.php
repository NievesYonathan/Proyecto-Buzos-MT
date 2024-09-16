<?php
include '../Modelo/Conexion.php';

class ModeloTarea {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectarse();
    }

    public function crearTarea($nombre, $descripcion, $estado, $plazo) {
        $sql = "INSERT INTO tarea (tar_nombre, tar_descripcion, tar_estado, Plazo_Ent_tar) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ssss', $nombre, $descripcion, $estado, $plazo);
        return $stmt->execute();
    }

    public function obtenerTareas() {
        $sql = "SELECT * FROM tarea";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTareaPorId($id) {
        $sql = "SELECT * FROM tarea WHERE id_tarea = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizarTarea($id, $nombre, $descripcion, $estado, $plazo) {
        $sql = "UPDATE tarea SET tar_nombre = ?, tar_descripcion = ?, tar_estado = ?, Plazo_Ent_tar = ? WHERE id_tarea = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ssssi', $nombre, $descripcion, $estado, $plazo, $id);
        return $stmt->execute();
    }


    public function eliminarTarea($id) {
        $sql = "DELETE FROM tarea WHERE id_tarea = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }



    public function actualizarEstadoTarea($id_tarea, $estado) {
        $query = "UPDATE tarea SET tar_estado = ? WHERE id_tarea = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("si", $estado, $id_tarea);
        return $stmt->execute();
    }
}


?>