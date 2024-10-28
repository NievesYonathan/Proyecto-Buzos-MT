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
        $idMateriasPrirmas = $newMatPro->getMatProduccionId($id_produccion);

        // Transformar el resultado en un array de IDs
        $existingMatPrimaIds = [];
        while ($row = $idMateriasPrirmas->fetch_assoc()) {
            $existingMatPrimaIds[] = $row['id_pro_materia_prima'];
        }

        // Encontrar los nuevos IDs de materias primas que no están en la base de datos
        $newMateriasPrima = array_diff($idMateriPrima, $existingMatPrimaIds);

        // Llamar a la función de añadir materia prima para cada nuevo ID
        foreach ($newMateriasPrima as $newMateria) {
            $index = array_search($newMateria, $idMateriPrima);
            $cantidad = $cantidadMP[$index];
            $newMatPro->addMatProduccion($cantidad, $newMateria, $id_produccion);
        }

        // Actualizar las materias primas existentes
        for ($i = 0; $i < count($idRegistrosMP); $i++) {
            $idRegistro = $idRegistrosMP[$i];
            $MateriPrima = $idMateriPrima[$i];
            $cantidad = $cantidadMP[$i];
            $newMatPro->editMatProduccion($cantidad, $MateriPrima, $id_produccion, $idRegistro);
        }

        $newEmpTarea = new EmpTarea();
        $idMateriasTareas = $newEmpTarea->tareasProduccionId($id_produccion);

        // Transformar el resultado en un array de IDs
        $existingTareas = [];
        while ($row = $idMateriasTareas->fetch_assoc()) {
            // Separar los IDs por comas y agregar cada uno al array
            //$tareasSeparadas = explode(',', $row['tarea_id_tarea']); // Cambia 'id_empleado_tarea' por el campo correcto
            $existingTareas[] = $row['tarea_id_tarea']; // Combina con el array existente
        }

        // Encontrar los nuevos IDs de materias primas que no están en la base de datos
        $newTareas = array_diff($tareaId, $existingTareas);

// Llamar a la función de añadir tarea para cada nuevo ID
foreach ($newTareas as $newTarea) {
    $index = array_search($newTarea, $tareaId);
    $numDoc = $numDocs[$index]; // Suponiendo que el numDoc está en el mismo índice que la tarea
    $fEntrega = $fEntregas[$index]; // Suponiendo que la fecha de entrega está en el mismo índice
    $fAsignacion = date('Y-m-d'); // Asignar la fecha actual como fecha de asignación
    $idEstado = 3; // O el estado que corresponda

    // Agregar la nueva tarea
    $newEmpTarea->addTareaProd($numDoc, $newTarea, $fAsignacion, $fEntrega, $idEstado, $id_produccion);
}
        // Actualizar las materias primas existentes
        for ($i = 0; $i < count($idRegistrosET); $i++) {
            $idRegistroET = $idRegistrosET[$i];
            $tarea = $tareaId[$i];
            $numDoc = $numDocs[$i];
            $fEntrega = $fEntregas[$i];

            $newEmpTarea->editarTareaProd($numDoc, $tarea, $fEntrega, $idRegistroET);
        }

        // Redirigir al final del proceso
        header("Location: ../Perfil-Produccion/vista-pro-fabricados.php");
        //exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorProduccion();

    if (isset($_POST['btn-produccion']) and $_POST['btn-produccion'] === "editar") {
        $controlador->editProduccion();
    } else {
        $controlador->addProduccion();
    }
}
