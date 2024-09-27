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

    public function selectCarUsuario()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT * FROM cargos_has_usuarios";
        $res = $conectar->query($sql);
        $conectar->close();

        return $res;
    }
    
    public function selectCarUsuarioDoc($numDoc)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT cargos_id_cargos FROM cargos_has_usuarios WHERE usuarios_num_doc = $numDoc";
        $res = $conectar->query($sql);
        $conectar->close();

        return $res;
    }

    public function desactivarCargo($cargosDesac, $idUsuario)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
         
        $estado = 2;

        $sql = "UPDATE cargos_has_usuarios SET estado_asignacion = ? WHERE cargos_id_cargos = ? AND usuarios_num_doc = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('sii', $estado, $cargosDesac, $idUsuario);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

    public function estadoCargo($idCargo, $idUsuario)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        
        $sql = "SELECT estado_asignacion FROM cargos_has_usuarios WHERE usuarios_num_doc = $idUsuario AND cargos_id_cargos = $idCargo";
        $res = $conectar->query($sql);
        $conectar->close();

        return $res;
    }

    public function activarCargo($idCargo, $idUsuario)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
         
        $estado = 1;

        $sql = "UPDATE cargos_has_usuarios SET estado_asignacion = ? WHERE cargos_id_cargos = ? AND usuarios_num_doc = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('sii', $estado, $idCargo, $idUsuario);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }
}