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

        $sql = "SELECT * FROM cargos_has_usuarios WHERE $numDoc";
        $res = $conectar->query($sql);
        $conectar->close();

        return $res;
    }

    public function desactivarCargo($cargosDesac)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
         
        $estado = "Inactivo";

        $sql = "UPDATE cargos_has_usuarios SET estado_asignacion = ? WHERE id_usuario_cargo = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('si', $estado, $cargosDesac);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }
}