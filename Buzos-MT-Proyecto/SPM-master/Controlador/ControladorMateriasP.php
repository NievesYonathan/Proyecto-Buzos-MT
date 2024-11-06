<?php
include_once '../Modelo/MateriaPrima.php';
include_once '../Modelo/Estado.php';
include_once "../Modelo/Usuarios.php";

// Mejor usar require_once para evitar problemas de inclusión múltiple

class ControladorProveedor
{
    public function mostrarProveedor()
    {
        $Proveedor = new Proveedor();
        $result = $Proveedor->mostrarProveedor();
        return $result;
    }
}

class ControladorMateriaPrima
{
    public function consultarMateriaPrima()
    {
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarMateriaPrima();
        return $result;
    }

    public function consultarMateriasPrimas($id_produccion)
    {
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarMateriasPrimas($id_produccion);
        return $result;
    }

    public function consultarEstados()
    {
        $MatObj = new MateriaPrima();
        $result = $MatObj->ConsultarEstados();
        return $result;
    }
    public function consultarEstadoMatPri($mpId)
    {
        $MatObj = new MateriaPrima();
        $result = $MatObj->consultarEstadoMatPri($mpId);
        return $result;
    }
    public function validarAcciones($accion)
    {
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
            header('Location: ../Perfil-Inventario/item-list.php');
        }
        if ($accion == 'actualizar') {
            $MatObj->actualizarMateriaPrima($mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId);
            header('Location: ../Perfil-Inventario/item-list.php');
        }
    }
    public function buscarMateriaPri(){
        if(!isset($_POST['busqueda'])){
            $_POST['busqueda'] = '';
        }
        $MatObj = new MateriaPrima();
        $result = $MatObj->BuscarMatPri($_POST['busqueda']);
            return $result;
    }
}

$contObj = new ControladorMateriaPrima();
$ProObj = new ControladorProveedor();
if (isset($_POST['accion'])) {
    return $contObj->validarAcciones($_POST['accion']);
}
