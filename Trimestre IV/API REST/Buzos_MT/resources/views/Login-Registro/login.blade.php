<?php
@include('partials.config.php');

// Manejo de errores de inicio de sesión antes de cualquier redirección
if (isset($_SESSION['login_errors'])) {
    foreach ($_SESSION['login_errors'] as $error) {
        echo "<p class='error'>$error</p>";
    }
    // Limpiar los errores de la sesión después de mostrarlos
    unset($_SESSION['login_errors']);
}

// Verificar si ya hay una sesión activa
if (isset($_SESSION['user_id'])) {
    // Si hay una sesión activa, redirigir al home (dashboard)
    header('Location: ../Dashboard/home.php');
    exit;
}
// Verificar si hay un mensaje de la sesión
if (isset($_SESSION['mensajes'])) {
    // El mensaje se mostrará en el cuerpo del HTML como una alerta de Bootstrap
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/css-login/login.css') }}">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Icono -->
    <link rel="icon" href="../assets/img/icon.png" sizes="32x32" type="image/png">
    <!-- CDN de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>

    <!-- Inicio Alerta PHP -->
    <?php
    if (isset($_SESSION['mensajes'])) {
    ?>
        <div id="alerta" class="alert alert-info" role="alert"
            style="position: fixed; top: 20px; left: 20px; padding: 15px; 
                border: 1px solid #12464c; border-radius: 8px; 
                background-color: #12464c; color: white; z-index: 9999;">
            <?php echo $_SESSION['mensajes']; ?>
        </div>

        <script>
            // Mover la alerta al principio del <body>
            var alerta = document.getElementById("mensajes");
            document.body.insertBefore(alerta, document.body.firstChild);

            // Ocultar la alerta después de 4 segundos
            setTimeout(function() {
                alerta.style.display = 'none';
            }, 4000); // 4000 milisegundos = 4 segundos
        </script>
    <?php
        unset($_SESSION['mensajes']);
    }
    ?>
    <!-- Fin Alerta PHP -->


    <section>
        <div class="full-box nav-lateral-content">
            <a href="{{ route('home')}}" class="btn btn-secondary" id="btn-reversa">
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
                            }, 5000); // 4000 milisegundos = 4 segundos
                        </script>
                    <?php
                        unset($_SESSION['alerta']);
                    }
                    ?>
                    <!-- Fin Alerta PHP -->
                    <div class="form">
                        <form class="form" method="POST" action="../Controlador/ControladorUsuario.php">
                            <h2>Iniciar Sesión</h2>
                            <div class="inputBox">
                                <select id="tipoDocumento" name="tipoDocumento" required>
                                    <option value=""> Tipo de documento</option>
                                    @foreach ($tiposDocumentos as $fila)
                                        <option value="{{ $fila->id_tipo_documento }}">{{ $fila->tip_doc_descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="inputBox">
                                <input type="text" id="numeroDocumento" name="numeroDocumento" placeholder="Número de Documento" requiered maxlength="10" required pattern="\d+{1,10}" title="Solo se permiten números">
                            </div>
                            <div class="inputBox">
                                <input type="password" id="password" name="password" placeholder="Contraseña" required pattern=".{8,}" title="Debe contener al menos 8 caracteres">
                            </div>
                            <div class="inputBox">
                                <button class="submit-btn" name="Accion" value="IniciarSesion">Iniciar</button>
                            </div>
                            <div class="inputBox">
                                <a class="submit-btn" href="{{ $google_client->createAuthUrl() }}">Iniciar con Gmail</a>
                            </div>
                            <p class="forget"><a href="registros.php">Registrarme</a></p>
                            <br>
                            <p class="forget"><a href="{{ $google_client->createAuthUrl() }}">Registrarme con Gmail</a></p>
                            <br>
                            <p class="forget"><a href="recuperar_contraseña.php">Olvide Mi Contraseña</a></p>
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