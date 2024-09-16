<?php
include_once '../Modelo/MateriaPrima.php';

class ControladorMateriaPrima{
public function consultarMateriaPrima(){
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarMateriaPrima();
        return $result;
    }
public function validarAcciones($accion){
    $MatObj = new MateriaPrima();
    $mpId = $_POST['mpId'];
    $mpNombres = $_POST['mpNombres'];
    $mpDescripcion = $_POST['mpDescripcion'];
    $mpCantidad = $_POST['mpCantidad'];
    $mpEstado = $_POST['mpEstado'];
        if ($accion == 'agregar') {
             $MatObj->agregarMateriaPrima($mpId, $mpNombres, $mpDescripcion);
             header('Location: ../Perfil-Inventario/item-list.php');
        }
        if ($accion == 'actualizar') {
            $MatObj->actualizarMateriaPrima($mpId, $mpNombres, $mpDescripcion, $mpCantidad, $mpEstado);
            header('Location: ../Perfil-Inventario/item-list.php');
        }  
        if($accion== 'cambiar'){
            return $MatObj->cambiarEstado($mpEstado,$mpId);
        }
        
    }
}
$MatObj = new ControladorMateriaPrima();
if (isset($_POST['accion'])) {
    return $MatObj->validarAcciones($_POST['accion']);
}