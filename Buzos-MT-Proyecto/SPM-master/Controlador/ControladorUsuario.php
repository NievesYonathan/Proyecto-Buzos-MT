<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                header("Location: ../Perfil-Admin-Usuarios/user-list.php?status=success");
            } else {
                $_SESSION['alerta'] = "Error al actualizar el usuario.";
                header("Location: ../Perfil-Admin-Usuarios/user-list.php?status=error");
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
                header("Location: ../Perfil-Admin-Usuarios/user-list.php?status=success");
                exit();
            } else {
                $_SESSION['alerta'] = "Error al inactivar el usuario.";
                header("Location: ../Perfil-Admin-Usuarios/user-list.php?status=error");
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



//Si se envían datos por POST, actualizar el usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorUsuario();
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
