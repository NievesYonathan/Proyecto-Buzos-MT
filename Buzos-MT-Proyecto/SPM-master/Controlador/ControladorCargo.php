<?php

include_once "../Modelo/Cargo.php";

class ControladorCargo
{
    public function crearCargo()
    {
        $carNombre = $_POST['cargo_sistema'];
        $controladorCargo = new Cargo();
        $controladorCargo->crearCargo($carNombre);

        header("Location: ../Perfil-Admin-Usuarios/cargos.php");
    }

    public function getCargo()
    {
        $controladorCargo = new Cargo();
        $res = $controladorCargo->getCargos();
        return $res;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorCargo();
    $controlador->crearCargo();
}