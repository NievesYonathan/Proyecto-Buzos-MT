<?php
include_once "../Modelo/ProFabricados.php";

class ConstroladorProFabricados{
    public function consultarPro(){
        $newPro = new ProFabricados();
        $res = $newPro->consultarPro();

        return $res;
    }
}