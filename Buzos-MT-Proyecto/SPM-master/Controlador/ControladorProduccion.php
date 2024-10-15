<?php
include_once "../Modelo/Produccion.php";
include_once "../Modelo/EmpTarea.php";
include_once "../Modelo/MatProduccion.php";

class ControladorProduccion
{
    public function addProduccion()
    {
        $pNombre = $_POST['produccion_nombre'];
        $fInicio = $_POST['produccion_fecha_inicio'];
        $fFin = $_POST['produccion_fecha_fin'];
        $pCantidad = $_POST['produccion_cantidad'];
        $pEtapa = $_POST['produccion_etapa'];

        $numDocs = $_POST['produccion_responsable'];
        $tareaId = $_POST['produccion_tarea'];
        $fAsignacion = date('Y-m-d');
        $fEntregas = $_POST['produccion_fecha_entrega'];
        $idEstado = 3;

        $cantidadMP = $_POST['mtPrima_cantidad'];
        $idMateriPrima = $_POST['produccion_mtPrima'];

        $newPro = new Produccion();
        $idProduccion = $newPro->agregarProduccion($pNombre, $fInicio, $fFin, $pCantidad, $pEtapa);

        $newEmpTarea = new EmpTarea();
        for ($i = 0; $i < count($tareaId); $i++) {
            $tarea = $tareaId[$i];
            $numDoc = $numDocs[$i];
            $fEntrega = $fEntregas[$i];
            $newEmpTarea->addTareaProd($numDoc, $tarea, $fAsignacion, $fEntrega, $idEstado, $idProduccion);
        }

        $newMatPro = new MatProduccion();
        for ($i = 0; $i < count($idMateriPrima); $i++) {
            $MateriPrima = $idMateriPrima[$i];
            $cantidad = $cantidadMP[$i];
            $newMatPro->addMatProduccion($cantidad, $MateriPrima, $idProduccion);
        }

        // Redirigir al final del proceso
        header("Location: ../Perfil-Produccion/vista-produccion.php");
        exit();
    }

    public function editProduccion()
    {
        $pNombre = $_POST['produccion_nombre'];
        $fFin = $_POST['produccion_fecha_fin'];
        $pCantidad = $_POST['produccion_cantidad'];
        $pEtapa = $_POST['produccion_etapa'];
        $id_produccion = $_POST['id_produccion'];

        $idRegistrosMP = $_POST['idRegistroMP'];
        $cantidadMP = $_POST['mtPrima_cantidad'];
        $idMateriPrima = $_POST['produccion_mtPrima'];

        $idRegistrosET = $_POST['idRegistroET'];
        $numDocs = $_POST['produccion_responsable'];
        $tareaId = $_POST['produccion_tarea'];
        $fEntregas = $_POST['produccion_fecha_entrega'];

        $newPro = new Produccion();
        $newPro->editarProduccion($id_produccion, $pNombre, $fFin, $pCantidad, $pEtapa);

        $newMatPro = new MatProduccion();
        for ($i = 0; $i < count($idRegistrosMP); $i++) {
            $idRegistro = $idRegistrosMP[$i];
            $MateriPrima = $idMateriPrima[$i];
            $cantidad = $cantidadMP[$i];
            $newMatPro->editMatProduccion($cantidad, $MateriPrima, $id_produccion, $idRegistro);
        }

        $newEmpTarea = new EmpTarea();
        for ($i = 0; $i < count($idRegistrosET); $i++) {
            $idRegistroET = $idRegistrosET[$i];
            $tarea = $tareaId[$i];
            $numDoc = $numDocs[$i];
            $fEntrega = $fEntregas[$i];
            // Imprimir cada valor de fEntrega
            echo "Iteración $i: numDoc = $numDoc, tarea = $tarea, fEntrega = $fEntrega, idProduccion = $id_produccion, idEmpTarea = $idRegistroET<br>";
            $newEmpTarea->editarTareaProd($numDoc, $tarea, $fEntrega, $id_produccion, $idRegistroET);
        }

        // Redirigir al final del proceso
        header("Location: ../Perfil-Produccion/vista-pro-fabricados.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorProduccion();

    if (isset($_POST['btn-editar']) and $_POST['btn-editar'] === "editar") {
        $controlador->editProduccion();
    } else {
        $controlador->addProduccion();
    }
}
