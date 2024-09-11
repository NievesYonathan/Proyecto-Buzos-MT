<?php
include_once "Conexion.php";

class CargosUsuarios {

    public function addRelaUsuarioCargo($idCargo, $numDoc, $fechaAsignacion, $estadoAsignacion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = " INSERT INTO cargos_has_usuarios(cargos_id_cargos, usuarios_num_doc, fecha_asignacion, estado_asignacion)
                VALUES (?, ?, ?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('iiss', $idCargo, $numDoc, $fechaAsignacion, $estadoAsignacion);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }
}