<?php
include_once "../Modelo/TipoDocumento.php";

class ControladorTipoDoc
{
    public function agrgarTipoDoc($tipoDocumento)
    {
        $objDoc = new TipoDocumento();
        $objDoc->agrgarTipoDoc($tipoDocumento);
        //header("Location: ../Perfil-Admin-Usuarios/tipoDocumentos.php");
    }

    public function consultarTipoDoc()
    {
        $objDoc = new TipoDocumento();
        $res = $objDoc->consultarTipoDoc();
        return $res;
    }

    public function setTipoDoc($id, $nombreDoc)
    {
        $objDoc = new TipoDocumento();
        $objDoc->setTipoDoc($id, $nombreDoc);
        header("Location: ../Perfil-Admin-Usuarios/tipoDocumentos.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $objDoc = new ControladorTipoDoc();
    if($_POST['Accion'] === "Actualizar"){
        $id = $_POST['id'];
        $nombreDoc =$_POST['nombreDoc'];
        $objDoc->setTipoDoc($id, $nombreDoc);
        
    } 
    if($_POST['Accion'] === "Crear"){
        $tipoDocumento = $_POST['nombreDoc'];
        $objDoc->agrgarTipoDoc($tipoDocumento);
    }
}