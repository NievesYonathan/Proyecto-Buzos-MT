<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login-Registro/login.php');
}

?>
<!DOCTYPE html>
<html lang="es">
<?php
include '../Config/variable_global.php';

include '../Componentes/Head/head.php' ?>

<body>
    <!-- Main container -->
    <main class="full-box main-container">
        <!-- Nav lateral -->
        <?php include '../Componentes/Sidebar/sidebar.php'; ?>

        <!-- Page content -->
        <section class="full-box page-content">
            <!-- Navbar -->
            <?php include '../Componentes/Navbar/navbar.php'; ?>

            <div class="full-box page-header">
                <h3 class="text-left"><i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR DATOS</h3>
            </div>

            <div class="container-fluid">
                <form method="post" action="../Controlador/ControladorUsuario.php" id="formActualizarUsuario">
                    <input type="hidden" name="Accion" value="Actualizar">
                    <fieldset>
                        <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_documento">Tipo documento</label>
                                        <select class="form-select" id="tipoDocumento" name="tipoDocumento" required>
                                            <option value=""> Tipo de documento</option>
                                            <?php
                                            include_once '../Modelo/Conexion.php';
                                            $conexion = new Conexion();
                                            $conectarse = $conexion->conectarse();

                                            $sql = "SELECT * FROM tipo_doc";
                                            $res = $conectarse->query($sql);
                                            $conectarse->close();

                                            while ($fila = mysqli_fetch_assoc($res)) { ?>
                                                <option value="<?= $fila['id_tipo_documento'] ?>"><?= $fila['tip_doc_descripcion'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_dni">Número de documento</label>
                                        <input type="text" class="form-control" name="usuario_dni" id="usuario_dni" value="<?php echo htmlspecialchars($num_doc); ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_nombre">Nombres</label>
                                        <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo htmlspecialchars($nombre); ?>" maxlength="35">
                                    </div>
                                </div>

                                <!-- Repite este patrón para los demás campos, quitando el atributo 'required' -->

                            </div>
                        </div>
                    </fieldset>
                    <br><br><br>
                    <fieldset>
                        <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Campos de información de la cuenta -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña (dejar en blanco si no desea cambiarla):</label>
                                        <input type="password" class="form-control" name="password" id="password" minlength="8">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="8">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-success btn-sm">
                            <i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR
                        </button>
                    </p>
                </form>
            </div>
        </section>
    </main>

    <!-- JavaScript files -->
    <?php include '../Componentes/Script/script.php'; ?>
    <script>
        document.getElementById('formActualizarUsuario').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>

</html>