<?php
session_start();

include_once "../Modelo/Usuarios.php";



class ControladorUsuario
{
    public function registroUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['numeroDocumento'];
            $tDoc = $_POST['tipoDocumento'];
            $usuNombres = $_POST['nombres'];
            $usuApellidos = $_POST['apellidos'];
            $usuFechaNacimiento = $_POST['fechaNacimiento'];
            $usuSexo = $_POST['sexo'];
            // $usuDireccion = $_POST[''];
            $usuTelefono = $_POST['celular'];
            $usuEmail = $_POST['correo'];
            $usuFechaContratacion = "2024-09-03";
            // $imagPerfil = $_POST[''];
            $clave = $_POST['password'];
            $confirmarClave = $_POST['confirm_password'];
            $confirmarClave = $_POST['confirm_password']; // Agregamos la confirmación de la contraseña

            // Validar si las contraseñas coinciden
            if ($clave !== $confirmarClave) {
                $_SESSION['alerta'] = "Las Contraseñas No Coinciden.";
                header("Location: ../Login-Registro/registros.php");
                exit();
            }

            $controladorUsuario = new Usuarios();
            $controladorUsuario->crearUsuario($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuTelefono, $usuFechaContratacion, $usuEmail, $clave);

            $_SESSION['alerta'] = "El Usuario Fue Registrado Con Éxito.";
            header("Location: ../Login-Registro/login.php");
        }
    }

    public function iniciarSesion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['numeroDocumento'];
            $tDoc = $_POST['tipoDocumento'];
            $clave = $_POST['password'];

            // Validar entrada
            $errors = [];

            // Verificar si los campos no están vacíos
            if (empty($numDoc)) {
                $errors[] = "El número de documento es requerido.";
            }
            if (empty($tDoc)) {
                $errors[] = "El tipo de documento es requerido.";
            }
            if (empty($clave)) {
                $errors[] = "La contraseña es requerida.";
            }

            // Validar número de documento (asumiendo que debe ser numérico y tener una longitud razonable)
            if (!empty($numDoc) && (!is_numeric($numDoc) || strlen($numDoc) < 5 || strlen($numDoc) > 20)) {
                $errors[] = "El número de documento no es válido.";
            }

            // Validar tipo de documento (asumiendo que debe ser uno de los tipos permitidos)
            $allowedDocTypes = [1, 2, 3]; // Agregar aquí todos los tipos de documento válidos
            if (!empty($tDoc) && !in_array($tDoc, $allowedDocTypes)) {
                $errors[] = "El tipo de documento no es válido.";
            }

            // Si hay errores, redirigir de vuelta a la página de inicio de sesión con mensajes de error
            if (!empty($errors)) {
                $_SESSION['login_errors'] = $errors;
                header("Location: ../Login-Registro/login.php");
                exit();
            }

            // Si la validación pasa, intentar iniciar sesión
            $controladorUsuario = new Usuarios();
            $resultado = $controladorUsuario->iniciarSesion($numDoc, $tDoc, $clave);
            // $fila = $resultado->fetch_assoc();

            // var_dump($fila);

            // $numDoc = $fila['num_doc'];
            // $cargo = $fila['car_nombre'];

            // $_SESSION['user_id'] = $numDoc; // Almacenar ID de usuario en la sesión
            // $_SESSION['user_cargo'] = $cargo;

            if ($resultado && $resultado->num_rows > 0) {
                // Inicio de sesión exitoso
                header("Location: ../Dashboard/home.php");
                exit();
            } else {
                // Inicio de sesión fallido
                $_SESSION['login_errors'] = ["Credenciales inválidas. Por favor, intente de nuevo."];
                header("Location: ../Login-Registro/login.php");
                exit();
            }
        }
    }

    // public function mostrarUsuarios()
    // {
    //     $controladorUsuario = new Usuarios();
    //     $res = $controladorUsuario->mostrarUsuarios();
    //     return $res;
    // }
    // public function compararAcciones()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $controlador = new ControladorUsuario();
    //         if ($_POST['Accion'] == "Registrar") {
    //             return $controlador->registroUsuario();
    //         }
    //         if ($_POST['Accion'] == "IniciarSesion") {
    //             return $controlador->iniciarSesion();
    //         }
    //     }
    // }



    // public function actualizarUsuario()
    // {
    //     $controladorUsuario = new ControladorUsuario();
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $numDoc = $_POST['num_doc'];
    //         $tipo_documento = $_POST['t_doc'];
    //         $nombre = $_POST['usu_nombres'];
    //         $apellido = $_POST['usu_apellidos'];
    //         $fechaNaciemiento = $_POST['usu_fecha_naciemiento'];
    //         $sexo = $_POST['sexo'];
    //         $direccion = $_POST['usu_direccion'];
    //         $telefono = $_POST['usu_telefono'];
    //         $email = $_POST['usu_email'];
    //         $fecha_contratacion = $_POST['usu_fecha_contratacion'];
    //         $controladorUsuario->actualizarUsuario($numDoc, $tipo_documento, $nombre, $apellido, $fechaNaciemiento, $sexo, $direccion, $telefono, $email, $fecha_contratacion);

    //         /*if ($controladorUsuario->actualizarUsuario($numDoc, $tipo_documento, $nombre, $apellido, $sexo, $direccion, $telefono, $email, $fecha_contratacion)) {
    //             header("Location: usuarios.php?status=success");
    //         } else {
    //             header("Location: usuarios.php?status=error");
    //         }*/
    //     }
    // }

    // public function mostrarUsuario($numDoc)
    // {
    //     $controladorUsuario = new Usuarios();
    //     return $controladorUsuario->obtenerUsuarioPornumDoc($numDoc);
    // }
}


//Si se envían datos por POST, actualizar el usuario
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controlador = new ControladorUsuario();
    if($_POST['Accion'] == "Registrar")
    {       
        $controlador->registroUsuario();
    }if ($_POST['Accion'] == "IniciarSesion") {
        $controlador->iniciarSesion();
    }
}