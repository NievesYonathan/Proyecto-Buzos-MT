<?php
include_once "../Modelo/Etapa.php";

class ControladorEtapa{
    public function consultarEtapas(){
        $etaObj = new Etapa();
        $res = $etaObj->consultarEtapas();
        return $res;
    }
}