<?php

include_once "Conexion.php";

class Seguridad {
    private $usuNum;
    private $hashClave;

    public function addClaveUsuario($usuNum, $clave)
    {
        $conexion = new Conexion();
        $conetar = $conexion->conectarse();

        $sql = "INSERT INTO seguridad(usu_num_doc, seg_clave_hash)
                VALUE (?,?)
        ";

        $stmt = $conetar->prepare($sql);
        $stmt->bind_param("is", $usuNum, $clave);
        $stmt->execute();
        $stmt->close();
        $conetar->close();
    }
}