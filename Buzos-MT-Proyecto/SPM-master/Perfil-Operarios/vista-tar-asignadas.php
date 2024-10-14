<?php
session_start();
include_once '../Config/variable_global.php';
include_once '../Componentes/Head/head.php';
include_once '../Modelo/ModeloTarea.php';

$conexion = new Conexion();
$conexion = $conexion->conectarse();

// Obtener estados, operarios y producciones
$modelo = new ModeloTarea();
$estados = $modelo->obtenerEstados();
$operarios = $modelo->obtenerOperarios();
$producciones = $modelo->obtenerProducciones();

// Consulta para obtener las tareas asignadas
$query = "
    SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, t.tar_estado, e.nombre_estado,
    emp.emp_tar_fecha_asignacion, emp.emp_tar_fecha_entrega
    FROM emp_tarea emp
    JOIN tarea t ON emp.tarea_id_tarea = t.id_tarea
    LEFT JOIN estados e ON t.tar_estado = e.id_estados
    WHERE emp.empleados_num_doc = ?";

$stmt = $conexion->prepare($query);
if (!$stmt) {
    die('Error en la preparación de la consulta: ' . mysqli_error($conexion));
}

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$resultado = $stmt->get_result();

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

$tareas = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Tareas Asignadas</title>
</head>
<body>
    <!-- Inicio Alerta PHP -->
    <?php
    if (isset($_SESSION['alerta'])) {
    ?>
        <div id="alerta" class="alert alert-info" role="alert"
            style="position: fixed; top: 20px; left: 20px; padding: 15px;
                    border: 1px solid #12464c; border-radius: 8px;
                    background-color: #12464c; color: white; z-index: 9999;">
            <?php echo $_SESSION['alerta']; ?>
        </div>

        <script>
            var alerta = document.getElementById("alerta");
            document.body.insertBefore(alerta, document.body.firstChild);
            setTimeout(function() {
                alerta.style.display = 'none';
            }, 4000);
        </script>
    <?php
        unset($_SESSION['alerta']);
    }
    ?>
    <!-- Fin Alerta PHP -->

    <!-- Nav lateral -->
    <?php include '../Componentes/Sidebar/sidebar.php'; ?>

    <!-- Page content -->
    <section class="full-box page-content">
        <!-- Navbar -->
        <?php include '../Componentes/Navbar/navbar.php'; ?>

        <!-- Page header -->
        <div class="full-box page-header">
            <h3 class="text-left">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TAREAS ASIGNADAS
            </h3>
        </div>

        <!-- Content -->
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>Nombre de la Tarea</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha de Asignación</th>
                            <th>Fecha de Entrega</th>
                            <th>Actualizar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tareas)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay tareas asignadas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tareas as $row): ?>
                                <tr class="text-center">
                                    <td><?php echo $row['id_tarea']; ?></td>
                                    <td><?php echo $row['tar_nombre']; ?></td>
                                    <td><?php echo $row['tar_descripcion']; ?></td>
                                    <td><?php echo $row['nombre_estado']; ?></td>
                                    <td><?php echo $row['emp_tar_fecha_asignacion']; ?></td>
                                    <td><?php echo $row['emp_tar_fecha_entrega']; ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#modalActualizarEstado<?php echo $row['id_tarea']; ?>">
                                            <i class="fas fa-edit"></i> Actualizar
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal para actualizar estado -->
                                <div class="modal fade" id="modalActualizarEstado<?php echo $row['id_tarea']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabelEstado<?php echo $row['id_tarea']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabelEstado<?php echo $row['id_tarea']; ?>">Actualizar Estado de Tarea</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="../Controlador/ControladorTarea.php">
                                                <input type="hidden" name="accion" value="actualizarEstado">
                                                <input type="hidden" name="id_tarea" value="<?php echo $row['id_tarea']; ?>">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="estadoTarea">Estado</label>
                                                        <select class="form-control" name="estadoTarea" required>
                                                            <?php foreach ($estados as $estado): ?>
                                                                <option value="<?php echo $estado['id_estados']; ?>" <?php echo $estado['id_estados'] == $row['tar_estado'] ? 'selected' : ''; ?>>
                                                                    <?php echo $estado['nombre_estado']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Include JavaScript files -->
        <?php include '../Componentes/Script/script.php'; ?>
    </body>
</html>

<?php
$stmt->close();
mysqli_close($conexion);
?>
