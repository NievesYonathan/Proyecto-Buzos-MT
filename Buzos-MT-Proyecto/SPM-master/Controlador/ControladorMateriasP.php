<?php 
include_once '../Modelo/MateriaPrima.php';
include_once '../Modelo/Estado.php';
include_once "../Modelo/Usuarios.php";

 // Mejor usar require_once para evitar problemas de inclusión múltiple

class ControladorProveedor  {
    public function mostrarProveedor() {
        $Proveedor = new Proveedor();
        $result = $Proveedor->mostrarProveedor();
     return $result;
    }
}

class ControladorMateriaPrima{
public function consultarMateriaPrima(){
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarMateriaPrima();
        return $result;
    }

public function consultarEstados(){
    $ObjEstado = new Estado();
    $result = $ObjEstado->ConsultarEstados();
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
        
    }
}

$contObj = new ControladorMateriaPrima();
$ProObj = new ControladorProveedor();
if (isset($_POST['accion'])) {
    return $contObj->validarAcciones($_POST['accion']);
}