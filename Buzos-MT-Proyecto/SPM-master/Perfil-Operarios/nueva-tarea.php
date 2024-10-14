<?php
session_start();
include '../Modelo/ModeloTarea.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php
include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
?>

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

    <!-- Main container -->
    <main class="full-box main-container">
        <?php include '../Componentes/Sidebar/sidebar.php'; ?>

        <section class="full-box page-content">
            <?php include '../Componentes/Navbar/navbar.php'; ?>

            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA
                </h3>
            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li><a class="active" href="nueva-tarea.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA</a></li>
                    <li><a href="lista-tareas.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE TAREAS</a></li>
                    <li><a href="buscar-tarea.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR TAREA</a></li>
                </ul>
            </div>

            <div class="container-fluid">
                <form method="post" action="../Controlador/ControladorTarea.php">

                    <fieldset>
                        <legend><i class="far fa-clipboard"></i> &nbsp; Detalles de la Tarea</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="nombreTarea" class="bmd-label-floating">Nombre de la Tarea</label>
                                        <input type="text" class="form-control" name="nombreTarea" id="nombreTarea" maxlength="50" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="descripcionTarea" class="bmd-label-floating">Descripción de tarea</label>
                                        <textarea class="form-control" name="descripcionTarea" id="descripcionTarea" maxlength="250" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="estadoTarea" class="bmd-label-floating">Estado de la tarea</label>
                                        <select class="form-control" name="estadoTarea" id="estadoTarea" required>
                                            <option value="" disabled selected>Selecciona un estado</option>
                                            <?php
                                            $modelo = new ModeloTarea();
                                            $estados = $modelo->obtenerEstados();
                                            if ($estados) {
                                                foreach ($estados as $estado) {
                                                    echo "<option value=\"{$estado['id_estados']}\">{$estado['nombre_estado']}</option>";
                                                }
                                            } else {
                                                echo "<option value=\"\">No hay estados disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="fechaAsignacion" class="bmd-label-floating">Fecha de Asignación</label>
                                        <input type="date" class="form-control" name="fechaAsignacion" id="fechaAsignacion" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="fechaEntrega" class="bmd-label-floating">Fecha de Entrega</label>
                                        <input type="date" class="form-control" name="fechaEntrega" id="fechaEntrega" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="usuario" class="bmd-label-floating">Asignar al Operario</label>
                                        <select class="form-control" name="usuario" id="usuario" required>
                                            <option value="" disabled selected>Selecciona un operario</option>
                                            <?php
                                            $operarios = $modelo->obtenerOperarios();
                                            if ($operarios) {
                                                foreach ($operarios as $operario) {
                                                    echo "<option value=\"{$operario['num_doc']}\">{$operario['usu_nombres']} {$operario['usu_apellidos']}</option>";
                                                }
                                            } else {
                                                echo "<option value=\"\">No hay operarios disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="produccion" class="bmd-label-floating">Producción</label>
                                        <select class="form-control" name="produccion" id="produccion" required>
                                            <option value="" disabled selected>Selecciona una producción</option>
                                            <?php
                                            $producciones = $modelo->obtenerProducciones();
                                            if ($producciones) {
                                                foreach ($producciones as $produccion) {
                                                    echo "<option value=\"{$produccion['id_produccion']}\">{$produccion['pro_nombre']}</option>";
                                                }
                                            } else {
                                                echo "<option value=\"\">No hay producciones disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    <p class="text-center" style="margin-top: 40px;">
                        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                        &nbsp; &nbsp;
                        <button type="submit" class="btn btn-raised btn-info btn-sm" name="accion" value="guardar"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
                    </p>
                </form>
            </div>

        </section>
    </main>

    <!--===Include JavaScript files======-->
    <?php include '../Componentes/Script/script.php'; ?>
</body>

</html>
