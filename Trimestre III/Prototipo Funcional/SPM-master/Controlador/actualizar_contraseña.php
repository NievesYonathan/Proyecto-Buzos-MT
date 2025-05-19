<?php
// Incluir la clase de conexión
require '../Modelo/Conexion.php';
require '../Modelo/ModeloUsuario.php';

// Iniciar la sesión
session_start();

// Crear una instancia de la conexión
$conexion = new Conexion();
$db = $conexion->conectarse();

// Crear una instancia del modelo de usuario
$modelUsuario = new ModeloUsuario($db);

// Verificar que la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el token y la nueva contraseña
    $token = $_POST['token'];
    $nuevaContraseña = password_hash($_POST['nueva_contraseña'], PASSWORD_BCRYPT);

    // Buscar al usuario por el token
    $usuario = $modelUsuario->buscarPorToken($token);

    if ($usuario && strtotime($usuario['token_expiracion']) > time()) {
        // Actualizar la contraseña en la base de datos
        $modelUsuario->actualizarContraseña($usuario['usu_num_doc'], $nuevaContraseña);

        // Limpiar el token de recuperación
        $modelUsuario->limpiarTokenRecuperacion($usuario['usu_num_doc']);

        // Guardar el mensaje en la sesión y redirigir
        $_SESSION['mensajes'] = "La contraseña ha sido actualizada correctamente.";
        header('Location: ../Login-Registro/login.php');
        exit();
    } else {
        // Guardar el mensaje de error en la sesión y redirigir
        $_SESSION['mensajes'] = "El token es inválido o ha expirado.";
        header('Location: ../Login-Registro/login.php');
        exit();
    }
}


