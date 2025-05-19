<?php

include_once "Conexion.php";

class TipoDocumento
{
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

    public function setTipoDoc($id, $tipoDocumento)
    {
        $conexion = new Conexion();
        $conetar = $conexion->conectarse();

        $sql = "UPDATE tipo_doc SET tip_doc_descripcion = ? WHERE id_tipo_documento = ?";

        $stmt = $conetar->prepare($sql);
        $stmt->bind_param("si", $tipoDocumento, $id);
        $stmt->execute();
        $stmt->close();
        $conetar->close();
    }

    public function consultarTipoDoc()
    {
        $conexion = new Conexion();
        $conectarse = $conexion->conectarse();

        $sql = "SELECT * FROM tipo_doc";
        $res = $conectarse->query($sql);
        $conectarse->close();

        return $res;
    }
}
