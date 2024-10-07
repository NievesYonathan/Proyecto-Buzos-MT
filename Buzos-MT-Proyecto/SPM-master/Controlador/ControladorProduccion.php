<?php
include_once "../Modelo/Produccion.php";
include_once "../Modelo/EmpTarea.php";
include_once "../Modelo/MatProduccion.php";

class ControladorProduccion {
    public function addProduccion()
    {
        $pNombre = $_POST['produccion_nombre'];
        $fInicio = $_POST['produccion_fecha_inicio'];
        $fFin = $_POST['produccion_fecha_fin'];
        $pCantidad = $_POST['produccion_cantidad'];
        $pEtapa = $_POST['produccion_etapa'];

        $numDoc = $_POST['produccion_responsable'];
        $tareaId = $_POST['produccion_tarea'];
        $fAsignacion = date('Y-m-d');
        $fEntrega = $_POST['produccion_fecha_entrega'];
        $idEstado = 3;

        $cantidadMP = $_POST['mtPrima_cantidad'];
        $idMateriPrima = $_POST['produccion_mtPrima'];

        $newPro = new Produccion();
        $idProduccion = $newPro->agregarProduccion($pNombre, $fInicio, $fFin, $pCantidad, $pEtapa);

        $newEmpTarea = new EmpTarea();
        foreach($tareaId as $tarea){
            $newEmpTarea->addTareaProd($numDoc, $tarea, $fAsignacion, $fEntrega, $idEstado, $idProduccion);
        }

        $newMatPro = new MatProduccion();
        foreach($idMateriPrima as $MateriPrima){
            $newMatPro->addMatProduccion($cantidadMP, $MateriPrima, $idProduccion);
        }

        // Redirigir al final del proceso
        header("Location: ../Perfil-Produccion/vista-produccion.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorProduccion();
    $controlador->addProduccion();
}