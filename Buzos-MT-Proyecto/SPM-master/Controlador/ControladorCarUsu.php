<?php
include_once "../Modelo/Conexion.php";

class ControladorCarUsu {

    public function asociarCarUsu(){
        $idCargo = $_POST['idCargo'];
        $idUsuario = $_POST['numDoc'];
        $fechaAsignacion = '2024-09-05';
        $estado = "Activo";

        include_once "../Modelo/CargosUsuarios.php";

        $objCarUsu = new CargosUsuarios();
        $objCarUsu->addRelaUsuarioCargo($idCargo, $idUsuario, $fechaAsignacion, $estado);

        header("Location: ../Perfil-Admin-Usuarios/user-list-cargo.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorCarUsu();
    $controlador->asociarCarUsu();
}