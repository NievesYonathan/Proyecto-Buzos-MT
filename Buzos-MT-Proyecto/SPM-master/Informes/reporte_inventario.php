<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login-Registro/login.php');
}

require_once '../Controlador/InventarioController.php';

$inventarioController = new InventarioController($db);
$datosInventario = $inventarioController->generarReporteInventario();
// Asegúrate de que $datosInventario esté definido
if (!isset($datosInventario)) {
    error_log("La variable datosInventario no está definida en reporte_inventario.php");
    $datosInventario = [];
}
require_once '../error_log.php';
?>

<!DOCTYPE html>
<html lang="es">
<?php

include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
?>

<body>
    <!-- Main container -->
    <main class="full-box main-container">
        <!-- Nav lateral -->
        <?php include '../Componentes/Sidebar/sidebar.php'
        ?>

        <!-- Page content -->
        <section class="full-box page-content">
            <!-- Navbar -->
            <?php include '../Componentes/Navbar/navbar.php' ?>

            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORME INVENTARIO
                </h3>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a class="active" href="reporte_inventario.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORME INVENTARIO</a>
                    </li>
                </ul>
            </div>

            <!-- CONTENT -->
            <div class="container-fluid tile-container">

                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>ID Producto</th>
                                <th>Nombre del Producto</th>
                                <th>Stock Actual</th>
                                <th>Stock Utilizado</th>
                                <th>Fecha de Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($datosInventario) && !empty($datosInventario)) {
                                foreach ($datosInventario as $fila) { ?>
                                    <tr class="text-center">
                                        <td><?= htmlspecialchars($fila['id_producto']) ?></td>
                                        <td><?= htmlspecialchars($fila['nombre_producto']) ?></td>
                                        <td><?= htmlspecialchars($fila['stock_actual']) ?></td>
                                        <td><?= htmlspecialchars($fila['stock_utilizado']) ?></td>
                                        <td><?= htmlspecialchars($fila['fecha_actualizacion']) ?></td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='5'>No hay datos de inventario disponibles. Por favor, verifica la conexión a la base de datos y la consulta SQL.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Gráfico estadístico -->
                <div>
                    <canvas id="graficoInventario"></canvas>
                </div>
            </div>

            <script>
                // Depuración
                console.log('Datos para la gráfica:', <?php echo json_encode($datosInventario); ?>);

                // Verifica si hay datos antes de crear la gráfica
                <?php if (isset($datosInventario) && !empty($datosInventario)) : ?>
                    const ctx = document.getElementById('graficoInventario').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode(array_column($datosInventario, 'nombre_producto')); ?>,
                            datasets: [{
                                label: 'Stock Actual',
                                data: <?php echo json_encode(array_column($datosInventario, 'stock_actual')); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }, {
                                label: 'Stock Utilizado',
                                data: <?php echo json_encode(array_column($datosInventario, 'stock_utilizado')); ?>,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Reporte de Inventario'
                                }
                            }
                        }
                    });
                <?php else : ?>
                    console.log('No hay datos para generar la gráfica');
                <?php endif; ?>
            </script>
</body>

</html>