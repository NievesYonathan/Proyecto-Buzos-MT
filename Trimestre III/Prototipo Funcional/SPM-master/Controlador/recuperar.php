<?php
// Incluir la clase de conexión y el modelo de usuario
require '../Modelo/Conexion.php';
require '../Modelo/ModeloUsuario.php';

// Incluir los archivos de PHPMailer
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

// Importar las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Iniciar la sesión
session_start();

// Crear una instancia de la conexión
$conexion = new Conexion();
$db = $conexion->conectarse();

// Crear una instancia del modelo de usuario
$modelUsuario = new ModeloUsuario($db);

// Verificar que la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el correo electrónico del formulario
    $email = $_POST['correo'];

    // Verificar si el correo existe en la base de datos
    $usuario = $modelUsuario->buscarPorEmail($email);

    if ($usuario) {
        // Generar un token de recuperación y guardarlo
        $token = bin2hex(random_bytes(3));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));  // Expira en 1 hora

        $modelUsuario->guardarTokenRecuperacion($usuario['num_doc'], $token, $expiracion);

        // Crear una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  
            $mail->SMTPAuth   = true;
            $mail->Username   = 'multygems.v@gmail.com';  
            $mail->Password   = 'bkao prll sskf rwse';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Destinatarios
            $mail->setFrom('multygems.v@gmail.com', 'Buzos Mayte');  // Cambia esto
            $mail->addAddress($email);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Codigo de recuperación de contrasena';
            $mail->Body    = "Su código de recuperacion es: <b>$token</b>";

            $mail->send();

            // Guardar mensaje en la sesión y redirigir
            $_SESSION['alerta'] = "Se ha enviado un correo con el código de recuperación.";
            header('Location: ../Login-Registro/actualizar_contraseña.php');
              // Importante para detener el script después de la redirección
        } catch (Exception $e) {
            $_SESSION['alerta'] = "No se pudo enviar el mensaje. Error de Mailer: {$mail->ErrorInfo}";
            header('Location: ../Login-Registro/recuperar_contraseña.php');
        }
    } else {
        $_SESSION['alerta'] = "Este correo no está registrado.";
        header('Location: ../Login-Registro/recuperar_contraseña.php');
    }
}
     