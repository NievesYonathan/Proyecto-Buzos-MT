<?php
include_once "../Modelo/TipoDocumento.php";

class ControladorTipoDoc{
    public function consultarTipoDoc(){
        $objDoc = new TipoDocumento();
        $res = $objDoc->consultarTipoDoc();
    }
}