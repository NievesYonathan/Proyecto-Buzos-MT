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

$query = "
    SELECT t.id_tarea, t.tar_nombre, t.tar_descripcion, t.tar_estado, e.nombre_estado,
    emp.empleados_num_doc, emp.emp_tar_fecha_asignacion, emp.emp_tar_fecha_entrega, emp.produccion_id_produccion
    FROM tarea t
    LEFT JOIN emp_tarea emp ON t.id_tarea = emp.tarea_id_tarea
    LEFT JOIN estados e ON t.tar_estado = e.id_estados
";

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
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
        <div class="container-fluid">
            <ul class="full-box list-unstyled page-nav-tabs">
                <li>
                    <a href="nueva-tarea.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA</a>
                </li>
                <li>
                    <a class="active" href="lista-tareas.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE TAREAS</a>
                </li>
                <li>
                    <a href="buscar-tarea.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR TAREA</a>
                </li>
            </ul>
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
                            <th>Actualizar</th>
                            <th>Visualizar Producción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                            <tr class="text-center">
                                <td><?php echo $row['id_tarea']; ?></td>
                                <td><?php echo $row['tar_nombre']; ?></td>
                                <td><?php echo $row['tar_descripcion']; ?></td>
                                <td><?php echo $row['nombre_estado']; ?></td>
                                <td><?php echo $row['emp_tar_fecha_asignacion']; ?></td>
                                <td><?php echo $row['emp_tar_fecha_entrega']; ?></td>
                                <td>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#modalActualizar<?php echo $row['id_tarea']; ?>">
                                        <i class="fas fa-edit"></i> Actualizar
                                    </button>
                                </td>
                                <td>
                                <a href="visualizar-tarea.php?id=<?php echo $row['id_tarea']; ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Visualizar
                                </a>
                                </td>
                            </tr>

                            <!-- Modal para actualizar tarea -->
<div class="modal fade" id="modalActualizar<?php echo $row['id_tarea']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?php echo $row['id_tarea']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel<?php echo $row['id_tarea']; ?>">Actualizar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="../Controlador/ControladorTarea.php">
                <input type="hidden" name="accion" value="actualizar">
                <input type="hidden" name="id_tarea" value="<?php echo $row['id_tarea']; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreTarea">Nombre de la Tarea</label>
                        <input type="text" class="form-control" name="nombreTarea" value="<?php echo $row['tar_nombre']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionTarea">Descripción</label>
                        <textarea class="form-control" name="descripcionTarea" required><?php echo $row['tar_descripcion']; ?></textarea>
                    </div>
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
                    <div class="form-group">
                        <label for="usuario">Operario</label>
                        <select class="form-control" name="usuario" required>
                            <?php foreach ($operarios as $operario): ?>
                                <option value="<?php echo $operario['num_doc']; ?>" <?php echo $operario['num_doc'] == $row['empleados_num_doc'] ? 'selected' : ''; ?>>
                                    <?php echo $operario['usu_nombres'] . ' ' . $operario['usu_apellidos']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="produccion">Producción</label>
                        <select class="form-control" name="produccion" required>
                            <?php foreach ($producciones as $produccion): ?>
                                <option value="<?php echo $produccion['id_produccion']; ?>" <?php echo $produccion['id_produccion'] == $row['produccion_id_produccion'] ? 'selected' : ''; ?>>
                                    <?php echo $produccion['pro_nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaAsignacion">Fecha de Asignación</label>
                        <input type="date" class="form-control" name="fechaAsignacion" value="<?php echo $row['emp_tar_fecha_asignacion']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaEntrega">Fecha de Entrega</label>
                        <input type="date" class="form-control" name="fechaEntrega" value="<?php echo $row['emp_tar_fecha_entrega']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--=== Include JavaScript files ======-->
        <?php include '../Componentes/Script/script.php' ?>
    </body>
</html>

<?php
mysqli_close($conexion);
?>
