<?php

include_once "Conexion.php";

class Seguridad {
    private $usuNum;
    private $hashClave;

    public function addClaveUsuario($usuNum, $clave)
    {
        $hashClave = password_hash($clave, PASSWORD_DEFAULT);

        $conexion = new Conexion();
        $conetar = $conexion->conectarse();

        $sql = "INSERT INTO seguridad(usu_num_doc, seg_clave_hash)
                VALUE (?,?)
        ";

        $stmt = $conetar->prepare($sql);
        $stmt->bind_param("is", $usuNum, $hashClave);
        $stmt->execute();
        $stmt->close();
        $conetar->close();
    }
}