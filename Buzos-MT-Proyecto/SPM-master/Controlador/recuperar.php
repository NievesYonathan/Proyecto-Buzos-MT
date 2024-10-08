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
        $token = bin2hex(random_bytes(4));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));  // Expira en 1 hora

        $modelUsuario->guardarTokenRecuperacion($usuario['num_doc'], $token, $expiracion);

        // Crear una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Cambia esto al servidor SMTP que uses
            $mail->SMTPAuth   = true;
            $mail->Username   = 'multygems.v@gmail.com';  // Cambia esto a tu correo
            $mail->Password   = 'bkao prll sskf rwse';  // Cambia esto a tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            


            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Destinatarios
            $mail->setFrom('multygems.v@gmail.com', 'Buzos Mayte');  // Cambia esto
            $mail->addAddress($email);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Código de recuperación de contraseña';
            $mail->Body    = "Su código de recuperación es: <b>$token</b>";

            $mail->send();
            echo "Se ha enviado un correo con el código de recuperación.";
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error de Mailer: {$mail->ErrorInfo}";
        }
    } else {
        echo "Este correo no está registrado.";
    }
}