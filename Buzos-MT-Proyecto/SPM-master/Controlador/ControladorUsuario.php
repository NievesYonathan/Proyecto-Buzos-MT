<?php
//session_start();

include_once "../Modelo/Usuarios.php";

class ControladorUsuario{
    public function registroUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
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
            $confirmarClave = $_POST['confirm_password']; $confirmarClave = $_POST['confirm_password']; // Agregamos la confirmación de la contraseña

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
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
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
            
            if ($resultado && $resultado->num_rows > 0) {
                // Inicio de sesión exitoso
                $fila = $resultado->fetch_assoc();

                $numDoc = $fila['clave_descifrada'];
                $cargo = $fila['clave_descifrada'];

                $_SESSION['user_id'] = $numDoc; // Almacenar ID de usuario en la sesión
                $_SESSION['user_cargo'] = $cargo; // Almacenar ID de usuario en la sesión
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

    public function mostrarUsuarios()
    {
        $controladorUsuario = new Usuarios();
        $res = $controladorUsuario->mostrarUsuarios();          
        return $res;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controlador = new ControladorUsuario();
    if($_POST['Accion'] == "Registrar")
    {       
        $controlador->registroUsuario();
    }if ($_POST['Accion'] == "IniciarSesion") {
        $controlador->iniciarSesion();
    }
}