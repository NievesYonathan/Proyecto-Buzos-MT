<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
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
            <?php
                if(isset($_SESSION['alerta'])){
                    ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $_SESSION['alerta'] ?>
                    </div>
                    <?php 
                    unset($_SESSION['alerta']);  
                }
                ?>

                <div class="form">
                    <form class="form" method="POST" action="../Controlador/ControladorRegistro.php">
                        <h2>Iniciar Sesión</h2>
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
                            <input type="password" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <div class="inputBox">
                            <button class="submit-btn" name="Accion" value="IniciarSesion">Iniciar</button>
                        </div>
                        <p class="forget"><a href="registros.php">No Tengo Un Usuario</a></p>
                        <br>
                        <p class="forget"><a href="not-password.php">Olvide Mi Contraseña</a></p>
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