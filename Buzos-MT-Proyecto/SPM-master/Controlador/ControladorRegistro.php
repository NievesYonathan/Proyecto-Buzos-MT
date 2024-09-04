<?php

include_once "../Modelo/Usuarios.php";

class ControladorRegistro{

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

            $registroUsuario = new Usuarios();
            $registroUsuario->crearUsuario($numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuTelefono, $usuFechaContratacion, $usuEmail, $clave);
        
            header("Location: ");
        }
    }
}

$controlador = new ControladorRegistro();
$controlador->registroUsuario();