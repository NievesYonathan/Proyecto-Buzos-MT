<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section>
        <div class="color"></div>
        <div class="color"></div>
        <div class="color"></div>
        <div class="box">
            <div class="square" style="--i:0;"></div>
            <div class="square" style="--i:1;"></div>
            <div class="square" style="--i:2;"></div>
            <div class="square" style="--i:3;"></div>
            <div class="square" style="--i:4;"></div>
            <div class="container">
                <div class="form">
                    <h2>Registro de Usuario</h2>
                    <form id="registroForm" action="../Controlador/ControladorRegistro.php" method="POST">
                        <div class="inputBox">
                            <select id="tipoDocumento" name="tipoDocumento" required>
                                <option value=""> Tipo de documento</option>
                                <option value="1">Cédula</option>
                                <option value="TI">TI</option>
                                <option value="Pasaporte">Pasaporte</option>
                            </select>
                        </div>
                        <div class="inputBox">
                            <input type="text" id="numeroDocumento" name="numeroDocumento" placeholder="Número de Documento" required pattern="\d+" title="Solo se permiten números">
                        </div>
                        <div class="inputBox">
                            <input type="text" id="nombres" name="nombres" placeholder="Nombres" required pattern="[A-Za-zÁ-ÿ\s]+" title="Solo se permiten letras y espacios">
                        </div>
                        <div class="inputBox">
                            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required pattern="[A-Za-zÁ-ÿ\s]+" title="Solo se permiten letras y espacios">
                        </div>
                        <div class="inputBox">
                            <label for="fechaNacimiento">F/N</label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" placeholder="fechaNacimiento" required>
                        </div>
                        <div class="inputBox">
                            <select id="sexo" name="sexo"required>
                                <option value="">Sexo</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="inputBox">
                            <input type="number" id="celular" name="celular" placeholder="Teléfono Celular" required>
                        </div>
                        <div class="inputBox">
                            <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" required>
                        </div>
                        <div class="inputBox">
                            <input type="password" id="password" name="password" placeholder="Contraseña" required pattern=".{8,}" title="Debe contener al menos 8 caracteres">
                        </div>
                        <!-- <div class="inputBox">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                        </div> -->
                        <div class="inputBox">
                            <button class="btn submit-btn" type="submit">Registrarme</button>
                        </div>
                        <p class="forget"><a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a></p>
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