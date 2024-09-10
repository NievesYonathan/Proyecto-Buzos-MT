<?php
include_once '../Modelo/MateriaPrima.php';

class ControladorMateriaPrima{
    public function consultarMateriaPrima(){
        
        $MatObj = new MateriaPrima();
        $consultar = $MatObj->consultarMateriaPrima();
        return $consultar;
    }
    public function crearMateriaPrima(){
        $matId = $_POST['matId'];
        $matNombre = $_POST['matNombre'];
        $matDescripcion = $_POST['matDescripcion'];
        $agregarMat = new MateriaPrima();
        $agregarMat->agregarMateriaPrima($matId,$matNombre,$matDescripcion);
        
    }

}