    <?php
    session_start();
    include '../Config/variable_global.php';
    include '../Componentes/Head/head.php';
    include '../Modelo/Conexion.php';

    $conexion = new Conexion();
    $conexion = $conexion->conectarse();

    $query = "SELECT * FROM tarea";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <!-- Incluye los estilos aquí si es necesario -->
    </head>

    <body>
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
                                <th>Plazo de Entrega</th>
                                <th>Actualizar</th>
                                <th>Visualizar la Producción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($row['id_tarea']); ?></td>
                                <td><?php echo htmlspecialchars($row['tar_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['tar_descripcion']); ?></td>
                                <td><?php echo htmlspecialchars($row['tar_estado']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($row['Plazo_Ent_tar']); ?></td>
                                <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalTarea" >Actualizar</button>

                                </td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detalleProduccion">Visualizar</button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal único -->
            <!-- Modal único -->
    <div class="modal fade" id="modalTarea" tabindex="-1" aria-labelledby="modalTareaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTareaLabel">Actualizar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="formTarea" method="POST" action="../Controlador/ControladorTarea.php">
    <input type="hidden" id="idTarea" name="idTarea">
    <div class="form-group">
        <label for="estadoTarea">Estado</label>
        <select class="form-control" id="estadoTarea" name="estado">
            <option>En Proceso</option>
            <option>Completada</option>
            <option>Pendiente</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar los cambios</button>
</form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modalTarea');
        modal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var idTarea = button.getAttribute('data-id');
            var modalBodyInput = modal.querySelector('#idTarea');
            modalBodyInput.value = idTarea;
        });
    });
    </script>


            <!-- Modal-Detalles-Producción -->
            <div class="modal fade" id="detalleProduccion" tabindex="-1" role="dialog" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de Producción:</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Contenido del modal aquí -->
                                    <div class="col-12">
                                                    <h6><strong>1. Nombre de la Producción:</strong></h6>
                                                    <p id="nombreProduccion">Buzos Amarillos de Algodón</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>2. Código de Producción:</strong></h6>
                                                    <p id="codigoProduccion">PROD-00123</p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <h6><strong>3. Fecha de Inicio:</strong></h6>
                                                    <p id="fechaInicio">01/08/2024</p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <h6><strong>4. Fecha Estimada de Finalización:</strong></h6>
                                                    <p id="fechaEstimadaFinalizacion">15/08/2024</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>5. Etapas de Producción:</strong></h6>
                                                    <ul id="etapasProduccion">
                                                        <li>Corte de tela</li>
                                                        <li>Costura</li>
                                                        <li>Revisión de calidad</li>
                                                    </ul>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>6. Estado Actual:</strong></h6>
                                                    <p id="estadoActual">2 - Armado de los patrones</p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <h6><strong>7. Cantidad Total a Producir:</strong></h6>
                                                    <p id="cantidadTotal">500 unidades</p>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <h6><strong>8. Cantidad Producida:</strong></h6>
                                                    <p id="cantidadProducida">250 unidades</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>9. Responsables:</strong></h6>
                                                    <ul id="responsables">
                                                        <li>Juan Pérez - Corte de tela</li>
                                                        <li>María García - Costura</li>
                                                        <li>Carlos López - Revisión de calidad</li>
                                                    </ul>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>10. Materiales Usados:</strong></h6>
                                                    <p id="materialesUsados">Algodón 100%, Hilo de poliéster</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>11. Recursos Asignados:</strong></h6>
                                                    <p id="recursosAsignados">Máquina de coser industrial, Mesa de corte, Personal de costura</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>12. Comentarios o Notas:</strong></h6>
                                                    <p id="comentariosNotas">Ajustar las costuras laterales para mayor durabilidad.</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>13. Historial de Cambios:</strong></h6>
                                                    <ul id="historialCambios">
                                                        <li>05/08/2024: Cambio de proveedor de hilo</li>
                                                        <li>07/08/2024: Ajuste en las medidas del patrón</li>
                                                    </ul>
                                                </div>
                                                <div class="col-12">
                                                    <h6><strong>14. Prioridad:</strong></h6>
                                                    <p id="prioridad">Alta</p>
                                                </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
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
        </section>

        <!--===Include JavaScript files======-->
        <?php include '../Componentes/Script/script.php' ?>
    </body>

    </html>

    <?php
    mysqli_close($conexion);
    ?>
