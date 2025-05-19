<?php
//Include Configuration File
include('../Login-Registro/config.php');

$login_button = '';


if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);


        $_SESSION['access_token'] = $token['access_token'];


        $google_service = new Google_Service_Oauth2($google_client);


        $data = $google_service->userinfo->get();


        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}




// Verificar si el usuario ya está registrado en la base de datos
include_once "../Modelo/Usuarios.php";
$usuRegistro = new Usuarios();
if (isset($_GET["code"])) {
    if ($_SESSION['user_email_address']) {
        $usuario = $usuRegistro->obtenerUsuarioPorGmail($_SESSION['user_email_address']);

        if ($usuario->num_rows > 0) {  // Asume que 'obtenerUsuarioPorGmail' retorna datos de usuario si existe
            $controlador = new ControladorUsuario();
            $controlador->iniciarSesionGmail($_SESSION['user_email_address']);
        } else {
            // Si el usuario no está registrado, redirigir o manejar el caso de nuevo registro
            // Ejemplo: Redirigir a una página de registro
            header("Location: ../Login-Registro/registros.php");
        }
    }
}



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
            $clave = $_POST['password'] ?? null;
            $confirmarClave = $_POST['confirm_password'] ?? null;
            $confirmarClave = $_POST['confirm_password'] ?? null;

            // Validar si las contraseñas coinciden
            if ($clave !== $confirmarClave) {
                $_SESSION['alerta'] = "Las Contraseñas No Coinciden.";
                header("Location: ../Login-Registro/registros.php");
                exit();
            }

            $controladorUsuario = new Usuarios();
            if (!isset($_SESSION['user_email_address'])) {
                $controladorUsuario->crearUsuario($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuTelefono, $usuFechaContratacion, $usuEmail, $clave);
            } else {
                $controladorUsuario->crearUsuarioGmail($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuTelefono, $usuFechaContratacion, $usuEmail);
            }

            $_SESSION['alerta'] = "El Usuario Fue Registrado Con Éxito.";
            header("Location: ../Login-Registro/login.php");
        }
    }


    public function insertarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['numeroDocumento'];
            $tDoc = $_POST['tipoDocumento'];
            $usuNombres = $_POST['nombres'];
            $usuApellidos = $_POST['apellidos'];
            $usuFechaNacimiento = $_POST['fechaNacimiento'];
            $usuSexo = $_POST['sexo'];
            $usuDireccion = $_POST['direccion'];
            $usuTelefono = $_POST['celular'];
            $usuEmail = $_POST['correo'];
            $usuFechaContratacion = $_POST['direccion'];
            $imagPerfil = " ";
            $clave = $_POST['password'];
            $confirmarClave = $_POST['confirm_password']; // Agregamos la confirmación de la contraseña

            // Validar si las contraseñas coinciden
            if ($clave !== $confirmarClave) {
                $_SESSION['alerta'] = "Las Contraseñas No Coinciden.";
                header("Location: ../Perfil-Admin-Usuarios/user-new.php");
                exit();
            }

            $controladorUsuario = new Usuarios();
            $controladorUsuario->crearUsuario($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuDireccion, $usuTelefono, $usuFechaContratacion, $usuEmail, $clave, $imagPerfil);

            $_SESSION['alerta'] = "El Usuario Fue Registrado Con Éxito.";
            header("Location: ../Perfil-Admin-Usuarios/user-list.php");
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

    public function iniciarSesionGmail($gmail)
    {
        $controladorUsuario = new Usuarios();
        $res = $controladorUsuario->iniciarSesionGmail($gmail);
        if ($res && $res->num_rows > 0) {
            // Inicio de sesión exitoso
            header("Location: ../Dashboard/home.php");
            exit();
        }
    }

    public function mostrarUsuarios()
    {
        $controladorUsuario = new Usuarios();
        $res = $controladorUsuario->mostrarUsuarios();
        return $res;
    }

    public function obtenerUsuarioOperario()
    {
        $controladorUsuario = new Usuarios();
        $res = $controladorUsuario->obtenerUsuarioOperario();
        return $res;
    }


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


    public function actualizarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['usuario_dni'];

            // Obtener los datos actuales del usuario
            $usuarioActual = $this->obtenerUsuarioPorNumDoc($numDoc);

            if (!$usuarioActual) {
                $_SESSION['alerta'] = "Usuario no encontrado.";
                header("Location: ../Perfil-Admin-Usuarios/user-list.php?status=error");
                exit();
            }

            // Actualizar solo los campos que se han modificado
            $tipo_documento = $_POST['tipo_documento'] ?? $usuarioActual['t_doc'];
            $nombre = $_POST['usuario_nombre'] ?? $usuarioActual['usu_nombres'];
            $apellido = $_POST['usuario_apellido'] ?? $usuarioActual['usu_apellidos'];
            $fechaNacimiento = $_POST['usuario_fecha_nacimiento'] ?? $usuarioActual['usu_fecha_nacimiento'];
            $sexo = $_POST['usuario_sexo'] ?? $usuarioActual['usu_sexo'];
            $direccion = $_POST['usuario_direccion'] ?? $usuarioActual['usu_direccion'];
            $telefono = $_POST['usuario_telefono'] ?? $usuarioActual['usu_telefono'];
            $email = $_POST['usuario_email'] ?? $usuarioActual['usu_email'];
            $fecha_contratacion = $_POST['usu_fecha_contratacion'] ?? $usuarioActual['usu_fecha_contratacion'];
            $estado = $_POST['usuario_estado'] ?? $usuarioActual['usu_estado'];
            $clave = !empty($_POST['password']) ? $_POST['password'] : null;

            $controladorUsuario = new Usuarios();
            $result = $controladorUsuario->actualizarUsuario($tipo_documento, $numDoc, $nombre, $apellido, $fechaNacimiento, $sexo, $direccion, $telefono, $email, $fecha_contratacion, $estado, $clave);

            if ($result) {
                $_SESSION['alerta'] = "Usuario actualizado con éxito.";
                // Redirigir a la misma vista
                $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../Perfil-Admin-Usuarios/user-list.php';
                header("Location: $redirectUrl?status=success");
                exit();
            } else {
                $_SESSION['alerta'] = "Error al actualizar el usuario.";
                // Redirigir a la misma vista
                $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../Perfil-Admin-Usuarios/user-list.php';
                header("Location: $redirectUrl?status=error");
                exit();
            }
            exit();
        }
    }

    private function obtenerUsuarioPorNumDoc($numDoc)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT * FROM usuarios WHERE num_doc = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("s", $numDoc);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        $stmt->close();
        $conectar->close();

        return $usuario;
    }

    public function eliminarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['num_doc'];

            // Cambiar el estado del usuario a inactivo
            $controladorUsuario = new Usuarios();
            $result = $controladorUsuario->eliminarUsuario($numDoc);

            if ($result) {
                $_SESSION['alerta'] = "Usuario inactivado con éxito.";
                // Redirigir a la misma vista
                $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../Perfil-Admin-Usuarios/user-list.php';
                header("Location: $redirectUrl?status=success");
                exit();
            } else {
                $_SESSION['alerta'] = "Error al inactivar el usuario.";
                // Redirigir a la misma vista
                $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../Perfil-Admin-Usuarios/user-list.php';
                header("Location: $redirectUrl?status=error");
                exit();
            }
        }
    }
    
    public function mostrarProveedor()
    {
        $modeloProveedor = new Usuarios(); // Asegúrate de usar el nombre correcto del modelo
        $res = $modeloProveedor->mostrarProveedor();
        return $res;
    }
    
    public function buscarUsuario($search) {
        $usuario = new Usuarios(); // Crear una instancia de Usuarios
        return $usuario->buscarUsuario($search); // Llamar al método buscarUsuario del modelo Usuarios
    }    

}

// class ControladorProveedor
// {
//     public function mostrarProveedor()
//     {
//         $modeloProveedor = new Proveedor(); // Asegúrate de usar el nombre correcto del modelo
//         $res = $modeloProveedor->mostrarProveedor();
//         return $res;
//     }
// }


// Si se envían datos por POST, actualizar el usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorUsuario();
    if (isset($_POST['Accion'])) { // Asegúrate de que la clave 'Accion' esté definida
        if ($_POST['Accion'] == "Registrar") {
            $controlador->registroUsuario();
        }
        if ($_POST['Accion'] == "IniciarSesion") {
            $controlador->iniciarSesion();
        }
        if ($_POST['Accion'] == "Actualizar") {
            $controlador->actualizarUsuario();
        }
        if ($_POST['Accion'] == "Guardar") {
            $controlador->insertarUsuario();
        }
        if ($_POST['Accion'] == "CambiarEstado") {
            $controlador->eliminarUsuario();
        }
        if ($_POST['Accion'] == "Buscar") { // Agregado: acción para buscar usuarios
            $controlador->buscarUsuario();
        }
    }
    
    if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $num_doc = $_POST['num_doc'];

        // Crear instancia del modelo y llamar a la función de eliminación
        $ControladorUsuario = new ControladorUsuario();
        $resultado = $ControladorUsuario->eliminarUsuario($num_doc);

        if ($resultado) {
            $_SESSION['alerta'] = 'Usuario eliminado exitosamente.';
        } else {
            $_SESSION['alerta'] = 'Error al eliminar el usuario.';
        }

        header('Location: user-list.php');
        exit();
    }
}

