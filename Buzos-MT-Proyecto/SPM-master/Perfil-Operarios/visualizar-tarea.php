<?php
session_start();
include_once '../Config/variable_global.php';
include_once '../Modelo/ModeloTarea.php';

$modelo = new ModeloTarea();

if (isset($_GET['id'])) {
    $idTarea = $_GET['id'];
    $tarea = $modelo->obtenerTareaPorId($idTarea);
    if (!$tarea) {
        $_SESSION['alerta'] = "Tarea no encontrada.";
        header('Location: lista-tareas.php');
        exit();
    }
} else {
    $_SESSION['alerta'] = "ID de tarea no proporcionado.";
    header('Location: lista-tareas.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../Componentes/Head/head.php'; ?>
</head>
<body>
    <?php include '../Componentes/Sidebar/sidebar.php'; ?>
    
    <section class="full-box page-content">
        <?php include '../Componentes/Navbar/navbar.php'; ?>

        <div class="full-box page-header">
            <h3 class="text-left"><i class="fas fa-eye"></i> &nbsp; VISUALIZAR TAREA</h3>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h5>Nombre de la Tarea: <?php echo htmlspecialchars($tarea['tar_nombre']); ?></h5>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($tarea['tar_descripcion']); ?></p>
                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($tarea['nombre_estado']); ?></p>
                    <p><strong>Fecha de Asignación:</strong> <?php echo htmlspecialchars($tarea['emp_tar_fecha_asignacion']); ?></p>
                    <p><strong>Fecha de Entrega:</strong> <?php echo htmlspecialchars($tarea['emp_tar_fecha_entrega']); ?></p>
                    <p><strong>Operario:</strong> <?php echo htmlspecialchars($tarea['usu_nombres'] . ' ' . $tarea['usu_apellidos']); ?></p>
                    <p><strong>Producción:</strong> <?php echo htmlspecialchars($tarea['pro_nombre']); ?></p>
                </div>
                <div class="card-footer">
                    <a href="lista-tareas.php" class="btn btn-secondary">Volver a la lista</a>
                </div>
            </div>
        </div>
    </section>

    <?php include '../Componentes/Script/script.php'; ?>
</body>
</html>
