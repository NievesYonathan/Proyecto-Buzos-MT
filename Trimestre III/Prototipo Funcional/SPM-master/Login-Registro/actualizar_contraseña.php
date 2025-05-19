<?php
// Iniciar la sesión
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si hay un mensaje de la sesión
if (isset($_SESSION['alerta'])) {
    // El mensaje se mostrará en el cuerpo del HTML como una alerta de Bootstrap
}
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
        <div class="full-box nav-lateral-content">
            <a href="login.php" class="btn btn-secondary" id="btn-reversa">
                <i class="fa fa-arrow-left"></i>
            </a>
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
            }, 6000); // 4000 milisegundos = 4 segundos
        </script>
        <?php 
        // Limpiar la alerta para que no se muestre de nuevo
        unset($_SESSION['alerta']);
    }
    ?>
    <!-- Fin Alerta PHP -->
                    <div class="form">
                        <h2>Restablecer Contraseña</h2>
                        <br><br><br>
                        <form action="../Controlador/actualizar_contraseña.php" method="POST">
                            <h2>Actualizar Contraseña</h2>
                            <div class="inputBox">
                                <input type="text" id="token" name="token" placeholder="Código de Recuperación" required>
                            </div>
                            <div class="inputBox">
                                <input type="password" id="nueva_contraseña" name="nueva_contraseña"
                                    placeholder="Nueva Contraseña" required>
                            </div>
                            <div class="inputBox">
                                <button type="submit" class="submit-btn">Actualizar</button>
                            </div>
                        </form>
                    </div>
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
