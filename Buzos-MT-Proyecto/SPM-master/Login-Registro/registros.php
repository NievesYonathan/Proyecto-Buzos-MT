<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Icono -->
    <link rel="icon" href="../assets/img/icon.png" sizes="32x32" type="image/png">
    <!-- CDN de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <section>
        <div class="full-boxx nav-lateral-content">
            <a href="../Login-Registro/login.php" class="btn btn-secondary" id="btn-reversas">
                <i class="fa fa-arrow-left"></i>
            </a>
            <div class="color"></div>
            <div class="color"></div>
            <div class="color"></div>
            <div class="box">
                <div class="squares" style="--i:0;"></div>
                <div class="squares" style="--i:1;"></div>
                <div class="squares" style="--i:2;"></div>
                <div class="squares" style="--i:3;"></div>
                <div class="squares" style="--i:4;"></div>
                <div class="container" id="registro-container">

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
                            // Mover la alerta al principio del <body>
                            var alerta = document.getElementById("alerta");
                            document.body.insertBefore(alerta, document.body.firstChild);

                            // Ocultar la alerta después de 4 segundos
                            setTimeout(function() {
                                alerta.style.display = 'none';
                            }, 4000); // 4000 milisegundos = 4 segundos
                        </script>
                    <?php
                        unset($_SESSION['alerta']);
                    }
                    ?>
                    <!-- Fin Alerta PHP -->

                    <div class="form">
                        <h2>Registro De Usuario</h2>
                        <form id="registroForm" action="../Controlador/ControladorUsuario.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inputBox">
                                        <select id="tipoDocumento" name="tipoDocumento" required>
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
                                    <div class="inputBox">
                                        <input type="text" id="numeroDocumento" name="numeroDocumento" placeholder="Número de Documento" requiered maxlength="10" required pattern="\d+{1,10}" title="Solo se permiten números">
                                    </div>
                                    <div class="inputBox">
                                        <input type="text" id="nombres" name="nombres" placeholder="Nombres" value="<?= $_SESSION['user_first_name'] ?>" required pattern="[A-Za-zÁ-ÿ\s]+" title="Solo se permiten letras y espacios">
                                    </div>
                                    <div class="inputBox">
                                        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= $_SESSION['user_last_name'] ?>" required pattern="[A-Za-zÁ-ÿ\s]+" title="Solo se permiten letras y espacios">
                                    </div>
                                    <?php
                                    if (!isset($_SESSION['user_email_address'])) {
                                    ?>
                                        <div class="inputBox">
                                            <input type="password" id="password" name="password" placeholder="Contraseña" required pattern=".{8,}" title="Debe contener al menos 8 caracteres">
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="col-md-6">
                                    <div class="inputBox">
                                        <select id="sexo" name="sexo" required>
                                            <option value="">Sexo</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="inputBox">
                                        <input type="number" id="celular" name="celular" placeholder="Teléfono Celular" requiered maxlength="10" required pattern="\d+{1,10}" title="Solo se permiten números">
                                    </div>
                                    <div class="inputBox">
                                        <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" value="<?= $_SESSION['user_email_address'] ?>" required>
                                    </div>

                                    <div class="inputBox">
                                        <input type="text" id="fechaNacimiento" name="fechaNacimiento" required title="Ingrese su fecha de nacimiento" onfocus="this.type='date'" onblur="this.type='text'" placeholder="Fecha de nacimiento">
                                    </div>

                                    <?php
                                    if (!isset($_SESSION['user_email_address'])) {
                                    ?>
                                        <div class="inputBox">
                                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required pattern=".{8,}" title="Debe contener al menos 8 caracteres">
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="inputBox">
                                <button class="submit-btn" type="submit" name="Accion" value="Registrar">Registrarme</button>
                            </div>
                            <p class="forget"><a href="login.php">Ya Tengo Una Cuenta<br>Iniciar Sesión</a></p>
                        </form>
                    </div>
                </div>
            </div>
    </section>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>