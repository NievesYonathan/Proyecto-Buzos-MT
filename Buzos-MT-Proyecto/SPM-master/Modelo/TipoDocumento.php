<?php

include_once "Conexion.php";

class TipoDocumento{
    private $tipoDocumento;

    public function agrgarTipoDoc($tipoDocumento)
    {
        $conexion = new Conexion();
        $conetar = $conexion->conectarse();

        $sql = "INSERT INTO tipo_doc (tip_doc_descripcion)
                VALUE (?)
        ";

        $stmt = $conetar->prepare($sql);
        $stmt->bind_param("s", $tipoDocumento);
        $stmt->execute();
        $stmt->close();
        $conetar->close();
    }
}