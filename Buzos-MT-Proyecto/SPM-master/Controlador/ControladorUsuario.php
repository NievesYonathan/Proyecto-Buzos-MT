<?php
//session_start();

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

 if (!empty ($_POST["btnguardar"])){

    if (!empty($_POST["usuario_dni"]) and 
    !empty($_POST["usuario_nombre"]) and 
    !empty($_POST["usuario_apellido"]) and 
    !empty($_POST["Fecha_nacimiento"]) and 
    !empty($_POST["sexo"]) and
    !empty($_POST["usuario_direccion"]) and
    !empty($_POST["usuario_telefono"]) and
    !empty($_POST["usu_fecha_contratacion"]) and
    !empty($_POST["usuario_email"]) and 
    !empty($_POST["usuario_clave_1"])){

    $numDoc = $_POST['usuario_dni'];
    $tDoc = $_POST['tipo_documento'];
    $usuNombres = $_POST['usuario_nombre'];
    $usuApellidos = $_POST['usuario_apellido'];
    $usuFechaNacimiento = $_POST['Fecha_nacimiento'];
    $usuTelefono = $_POST['usuario_telefono'];
    $usuSexo = $_POST['sexo'];
    $usuDireccion = $_POST['usuario_direccion'];
    $usuEmail = $_POST['correo'];
    $usuFechaContratacion = "usu_fecha_contratacion";
    $clave = $_POST['usuario_clave_1'];

    $sql=$conexion->query("insert into usuarios(usuario_dni,tipo_documento,usuario_nombre,usuario_apellido,Fecha_nacimiento,sexo,usuario_direccion,usuario_telefono,usu_fecha_contratacion,usuario_email,usuario_clave_1) values('$numDoc','$tDoc','$usuNombres',' $usuApellidos',' $usuFechaNacimiento','$usuTelefono','$usuSexo',' $usuDireccion','$usuEmail','$usuFechaContratacion','$clave') ");
    if($sql==1) {
        echo '<div class="alert-success"> usuaior insertado correctamente</div>';
    } else {
        echo '<div class="alert-success"> error al insertar usuario</div>';
    }

 }else{
    echo '<div class="alert alert-warning"> algún campo está vacio</div>';
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
    public function compararAcciones()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controlador = new ControladorUsuario();
            if ($_POST['Accion'] == "Registrar") {
                return $controlador->registroUsuario();
            }
            if ($_POST['Accion'] == "IniciarSesion") {
                return $controlador->iniciarSesion();
            }
        }
    }



    public function actualizarUsuario()
    {
        $controladorUsuario = new ControladorUsuario();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numDoc = $_POST['num_doc'];
            $tipo_documento = $_POST['t_doc'];
            $nombre = $_POST['usu_nombres'];
            $apellido = $_POST['usu_apellidos'];
            $fechaNaciemiento = $_POST['usu_fecha_nacimiento'];
            $sexo = $_POST['sexo'];
            $direccion = $_POST['usu_direccion'];
            $telefono = $_POST['usu_telefono'];
            $email = $_POST['usu_email'];
            $fecha_contratacion = $_POST['usu_fecha_contratacion'];
            $controladorUsuario->actualizarUsuario($numDoc, $tipo_documento, $nombre, $apellido, $fechaNaciemiento, $sexo, $direccion, $telefono, $email, $fecha_contratacion);

            /*if ($controladorUsuario->actualizarUsuario($numDoc, $tipo_documento, $nombre, $apellido, $sexo, $direccion, $telefono, $email, $fecha_contratacion)) {
                header("Location: usuarios.php?status=success");
            } else {
                header("Location: usuarios.php?status=error");
            }*/
        }
    }

    public function mostrarUsuario($numDoc)
    {
        $controladorUsuario = new Usuarios();
        return $controladorUsuario->obtenerUsuarioPornumDoc($numDoc);
    }
}

// Si se envían datos por POST, actualizar el usuario
$controladorUsuario = new ControladorUsuario();

