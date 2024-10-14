<!DOCTYPE html>
<html lang="es">
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login-Registro/login.php');
}

include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
?>

<body>
    <!-- Main container -->
    <main class="full-box main-container">
        <!-- Nav lateral -->
        <?php include '../Componentes/Sidebar/sidebar.php' ?>

        <!-- Page content -->
        <section class="full-box page-content">
            <!-- Navbar -->
            <?php include '../Componentes/Navbar/navbar.php' ?>

            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORMES Y REPORTES
                </h3>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="informes.php"><i class="fas fa-plus fa-fw"></i> &nbsp; INFORME INVENTARIO</a>
                    </li>
                    <li>
                        <a href="info-produccion.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORME PRODUCCION</a>
                    </li>
                    <li>
                        <a class="active" href="info-Rec.Humanos.php"><i class="fas fa-search fa-fw"></i> &nbsp; INFORME RECURSOS HUMANOS</a>
                    </li>
                </ul>
            </div>
            
            <!-- CONTENT -->
            <div class="container-fluid tile-container">
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th class="clickable-col" data-col="activos">EMPLEADOS ACTIVOS</th>
                                <th class="clickable-col" data-col="cargos">EMPLEADOS CON CARGO</th>
                                <th class="clickable-col" data-col="inactivos">USUARIOS INACTIVOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once '../Modelo/Conexion.php';
                            include_once "../Controlador/ControladorUsuario.php";

                            $conexion = new Conexion();
                            $conectarse = $conexion->conectarse();

                            // Consulta para contar empleados activos
                            $sqlActivos = "SELECT COUNT(*) as total_activos FROM usuarios WHERE usu_estado = '1'";
                            $resActivos = $conectarse->query($sqlActivos);
                            if (!$resActivos) {
                                die("Error en la consulta de empleados activos: " . $conectarse->error);
                            }
                            $activos = $resActivos->fetch_assoc();

                            // Consulta para contar empleados con cargo
                            $sqlConCargo = "SELECT COUNT(DISTINCT u.num_doc) as total_con_cargo 
                            FROM usuarios u
                            INNER JOIN cargos_has_usuarios cu ON u.num_doc = cu.usuarios_num_doc";
                            $resConCargo = $conectarse->query($sqlConCargo);
                            if (!$resConCargo) {
                                die("Error en la consulta de empleados con cargo: " . $conectarse->error);
                            }
                            $conCargo = $resConCargo->fetch_assoc();

                            // Consulta para contar usuarios inactivos
                            $sqlInactivos = "SELECT COUNT(*) as total_inactivos FROM usuarios WHERE usu_estado = '2'";
                            $resInactivos = $conectarse->query($sqlInactivos);
                            if (!$resInactivos) {
                                die("Error en la consulta de usuarios inactivos: " . $conectarse->error);
                            }
                            $inactivos = $resInactivos->fetch_assoc();
                            ?>
                            <tr class="text-center">
                                <td><?= $activos['total_activos'] ?></td>
                                <td><?= $conCargo['total_con_cargo'] ?></td>
                                <td><?= $inactivos['total_inactivos'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                    </ul>
                </nav>
            </div>
        </section>
    </main>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detalles de Usuarios</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="max-height: 60vh; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>tipo_doc</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Cargo</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <!-- Aquí se llenarán los datos de los usuarios -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Include JavaScript files -->
    <?php include '../Componentes/Script/script.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
       $(document).ready(function() {
    $('.clickable-col').on('click', function() {
        const columnType = $(this).data('col');
        fetchUserData(columnType);
    });

    function fetchUserData(column) {
        let query = '';
        if (column === 'activos') {
            query = "SELECT u.num_doc, u.usu_nombres, u.usu_apellidos, u.usu_telefono, u.usu_email, t.tip_doc_descripcion as tipo_doc FROM usuarios u INNER JOIN tipo_doc t ON u.t_doc = t.id_tipo_documento WHERE u.usu_estado = '1'";
        } else if (column === 'cargos') {
            query = "SELECT u.num_doc, u.usu_nombres, u.usu_apellidos, u.usu_telefono, u.usu_email, t.tip_doc_descripcion as tipo_doc, c.car_nombre as cargo FROM usuarios u INNER JOIN tipo_doc t ON u.t_doc = t.id_tipo_documento LEFT JOIN cargos_has_usuarios cu ON u.num_doc = cu.usuarios_num_doc LEFT JOIN cargos c ON cu.cargos_id_cargos = c.id_cargos";
        } else if (column === 'inactivos') {
            query = "SELECT u.num_doc, u.usu_nombres, u.usu_apellidos, u.usu_telefono, u.usu_email, t.tip_doc_descripcion as tipo_doc FROM usuarios u INNER JOIN tipo_doc t ON u.t_doc = t.id_tipo_documento WHERE u.usu_estado = '2'";
        }

        if (query !== '') {
            $.ajax({
                url: 'fetch_user_data.php',
                type: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#userTableBody').html(data);
                    $('#userModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            console.error('Consulta vacía');
        }
    }
});

    </script>
</body>
</html>
