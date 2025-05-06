<?php
include_once 'Conexion.php';
class Estado {
    public function crearEstado($nombre_estado)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "INSERT INTO estados (nombre_estado)
                VALUE (?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("s", $nombre_estado);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

    public function ConsultarEstados(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM estados';
        $result = mysqli_query($conectar,$sql);
        return $result;
    }

    public function setEstado($id, $nombre)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = "UPDATE estados SET nombre_estado = ? WHERE id_estados = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

}
