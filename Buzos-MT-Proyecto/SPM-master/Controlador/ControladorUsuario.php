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

            $controladorUsuario = new Usuarios();
            $controladorUsuario->crearUsuario($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuTelefono, $usuFechaContratacion, $usuEmail, $clave);
        
            $_SESSION['alerta'] = "El Uusario Fue Registrado Con Éxito.";
            header("Location: ../Login-Registro/login.php");
        }
    }

    public function iniciarSesion()
    {
        if($_SERVER['REQUEST_METHOD'] = 'POST')
        {
            $numDoc = $_POST['numeroDocumento'];
            $tDoc = $_POST['tipoDocumento'];
            $clave = $_POST['password'];
            
            $controladorUsuario = new Usuarios();
            $controladorUsuario->iniciarSesion($numDoc, $tDoc, $clave);
        
            header("Location: ../Dashboard/home.php");
        }
    }

    public function mostrarUsuarios()
    {
        // if($_SERVER['REQUEST_METHOD'] = 'GET')
        // {
            
            $controladorUsuario = new Usuarios();
            $res = $controladorUsuario->mostrarUsuarios();          
            return $res;
        //     header("Location: ../Dashboard/home.php");
        // }
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
