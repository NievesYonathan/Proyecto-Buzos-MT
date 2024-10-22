<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login-Registro/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Aquí asumo que ya tienes la lógica para obtener los datos del usuario
include_once '../Modelo/Conexion.php';
$conexion = new Conexion();
$conectarse = $conexion->conectarse();

$sql = "SELECT * FROM usuarios WHERE num_doc = ?";
$stmt = $conectarse->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
?>

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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_documento">Tipo documento:</label>
                                        <select class="form-select" id="tipoDocumento" name="tipoDocumento" disabled>
                                            <?php
                                            $sql = "SELECT * FROM tipo_doc";
                                            $res = $conectarse->query($sql);
                                            while ($fila = mysqli_fetch_assoc($res)) { ?>
                                                <option value="<?= $fila['id_tipo_documento'] ?>" <?= ($fila['id_tipo_documento'] == $usuario['t_doc'] ? 'selected' : '') ?>><?= $fila['tip_doc_descripcion'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_dni">Número de documento:</label>
                                        <input type="text" class="form-control" name="usuario_dni" id="usuario_dni" value="<?php echo htmlspecialchars($usuario['num_doc']); ?>" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_nombre">Nombres:</label>
                                        <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo htmlspecialchars($usuario['usu_nombres']); ?>" maxlength="35">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_apellido">Apellidos:</label>
                                        <input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="<?php echo htmlspecialchars($usuario['usu_apellidos']); ?>" maxlength="35">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_telefono">Teléfono:</label>
                                        <input type="text" class="form-control" name="usuario_telefono" id="usuario_telefono" value="<?php echo htmlspecialchars($usuario['usu_telefono']); ?>" maxlength="15">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_email">Email:</label>
                                        <input type="email" class="form-control" name="usuario_email" id="usuario_email" value="<?php echo htmlspecialchars($usuario['usu_email']); ?>" maxlength="70">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="Sexo">Sexo:</label>
                                        <input type="text" class="form-control" name="usuario_sexo" id="usuario_sexo" value="<?php echo htmlspecialchars($usuario['usu_sexo']); ?>" maxlength="70">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <br>

                    <fieldset>
                        <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                        <div class="container-fluid">
                            <div class="row">
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
