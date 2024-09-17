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
    $mpId = $_POST['matId']; 
$mpNombres = $_POST['matNombre'];
$mpDescripcion = $_POST['matDescripcion'];
$mpUnidadMedida = $_POST['matUnidad'];
$mpCantidad = $_POST['matCantidad'];
$mpEstado = $_POST['matEstado'];
$mpFechaCompra=$_POST['matFechaCompra'];

        if ($accion == 'agregar') {
             $MatObj->agregarMateriaPrima($mpId,$mpNombres,$mpDescripcion,$mpUnidadMedida,$mpCantidad,$mpEstado,$mpFechaCompra);
            return header('Location: ../Perfil-Inventario/item-list.php');
        }
        if ($accion == 'actualizar') {
            header('Location: ../Perfil-Inventario/item-list.php');
            $MatObj->actualizarMateriaPrima($mpNombres,$mpDescripcion,$mpCantidad,$mpEstado,$mpId);
            
        }  
        if($accion== 'cambiar'){
            return $MatObj->cambiarEstado($mpEstado,$mpId);
        }
    }
}
$contObj = new ControladorMateriaPrima();
if (isset($_POST['accion'])) {
    return $MatObj->validarAcciones($_POST['accion']);
}