<?php
session_start();
include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
include '../Modelo/ModeloTarea.php';

$modelo = new ModeloTarea();

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$resultado = null;

if ($busqueda) {

    if (is_numeric($busqueda)) {
        $_SESSION['alerta'] = "Por favor, busca por el nombre de la tarea, no por el ID.";
    } else {
        $resultado = $modelo->buscarTarea($busqueda);
        if ($resultado && $resultado->num_rows === 0) {
            $_SESSION['alerta'] = "No se encontraron resultados para '$busqueda'.";
        } else {
            $_SESSION['alerta'] = "Búsqueda realizada para '$busqueda'.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <main class="full-box main-container">
        <!-- Nav lateral -->
        <?php include '../Componentes/Sidebar/sidebar.php'; ?>

        <!-- Page content -->
        <section class="full-box page-content">
            <!-- Navbar -->
            <?php include '../Componentes/Navbar/navbar.php'; ?>

            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR TAREA.
                </h3>
            </div>

            <!-- Inicio Alerta PHP -->
            <?php if (isset($_SESSION['alerta'])): ?>
                <div class="alert alert-info" role="alert" style="position: fixed; top: 20px; left: 20px; padding: 15px; border: 1px solid #12464c; border-radius: 8px; background-color: #12464c; color: white; z-index: 9999;">
                    <?php echo $_SESSION['alerta']; ?>
                </div>
                <script>
                    setTimeout(function() {
                        document.querySelector('.alert').style.display = 'none';
                    }, 4000);
                </script>
                <?php unset($_SESSION['alerta']); ?>
            <?php endif; ?>
            <!-- Fin Alerta PHP -->

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li><a href="nueva-tarea.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA</a></li>
                    <li><a href="lista-tareas.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE TAREAS</a></li>
                    <li><a class="active" href="buscar-tarea.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR TAREA</a></li>
                </ul>
            </div>

            <!-- Content -->
            <div class="container-fluid">
                <form class="form-neon" method="GET" action="buscar-tarea.php">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="inputSearch" class="bmd-label-floating">¿Qué tarea estás buscando?</label>
                                    <input type="text" class="form-control" name="busqueda" id="inputSearch" maxlength="30" value="<?php echo htmlspecialchars($busqueda); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-center" style="margin-top: 40px;">
                                    <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>#</th>
                                <th>NOMBRE DE LA TAREA</th>
                                <th>DESCRIPCIÓN</th>
                                <th>FECHA LÍMITE</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado && $resultado->num_rows > 0) { ?>
                                <?php while ($row = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($row['id_tarea']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tar_nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tar_descripcion']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['fecha_entrega']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombre_estado']); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">No se encontraron resultados.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </main>

    <!--=== Include JavaScript files ===-->
    <?php include '../Componentes/Script/script.php'; ?>
</body>
</html>
