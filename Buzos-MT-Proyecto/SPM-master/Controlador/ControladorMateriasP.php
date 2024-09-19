<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $_POST['accion']; 
        ?>
    </title>
</head>
<body>
    
</body>
</html>
<?php
include_once '../Modelo/MateriaPrima.php';

class ControladorMateriaPrima{
public function consultarMateriaPrima(){
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarMateriaPrima();
        return $result;
    }

public function consultarEstados(){
    $MatObj = new MateriaPrima();
    $result = $MatObj->consultarEstados();
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
        $mpFechaCompra = $_POST['matFechaCompra'];
        $mpProveedor = $_POST['matProveedor'];

        if ($accion == 'agregar') {
            $MatObj->agregarMateriaPrima($mpNombres, $mpDescripcion, $mpUnidadMedida, $mpCantidad, $mpEstado, $mpFechaCompra, $mpProveedor);
            return header('Location: ../Perfil-Inventario/item-list.php');
        }
         if ($accion == 'actualizar') {
            $MatObj->actualizarMateriaPrima($mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId);
            return header('Location: ../Perfil-Inventario/item-list.php');   
        }
        //if ($accion == 'cambiar') {
          //  return $MatObj->cambiarEstado($mpEstado, $mpId);
        //}
    }
}

$contObj = new ControladorMateriaPrima();
if (isset($_POST['accion'])) {
    return $contObj->validarAcciones($_POST['accion']);
}