<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <!-- Asegúrate de incluir tus archivos CSS aquí -->
</head>
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
                                        <select class="form-control" name="tipo_documento" id="tipo_documento">
                                            <option value="">Seleccione tipo de documento</option>
                                            <option value="CC" <?php echo ($tipo_documento === 'CC') ? 'selected' : ''; ?>>Cédula de ciudadanía</option>
                                            <option value="CE" <?php echo ($tipo_documento === 'CE') ? 'selected' : ''; ?>>Cédula de extranjería</option>
                                            <option value="PPT" <?php echo ($tipo_documento === 'PPT') ? 'selected' : ''; ?>>Permiso por Protección Temporal</option>
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