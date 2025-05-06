<?php

include_once "../Modelo/Cargo.php";

class ControladorCargo
{
    public function crearCargo()
    {
        $carNombre = $_POST['cargo_sistema'];
        $controladorCargo = new Cargo();
        $controladorCargo->crearCargo($carNombre);

        header("Location: ../Perfil-Operarios/nueva-tarea.php");
    }

    public function getCargo()
    {
        $controladorCargo = new Cargo();
        $res = $controladorCargo->getCargos();
        return $res;
    }

    public function setCargo($id, $nombre)
    {
        $controladorCargo = new Cargo();
        $controladorCargo->setCargos($id, $nombre);
        header("Location: ../Perfil-Admin-Usuarios/cargos.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorCargo();
    if($_POST['Accion'] === "Actualizar"){
        $id = $_POST['id'];
        $car_nombre =$_POST['car_nombre'];
        $controlador->setCargo($id, $car_nombre);
    } else {
        $controlador->crearCargo();
    }
}