<?php

include_once "../Modelo/Estado.php";

class ControladorEstado
{
    public function crearEstado($car_nombre)
    {
        $controladorEstado = new Estado();
        $controladorEstado->crearEstado($car_nombre);

        header("Location: ../Perfil-Admin-Usuarios/vistaEstados.php");
    }

    public function getEstado()
    {
        $controladorEstado = new Estado();
        $res = $controladorEstado->ConsultarEstados();
        return $res;
    }

    public function setEstado($id, $nombre)
    {
        $controladorEstado = new Estado();
        $controladorEstado->setEstado($id, $nombre);
        header("Location: ../Perfil-Admin-Usuarios/vistaEstados.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorEstado();
    if($_POST['Accion'] === "Actualizar"){
        $id = $_POST['id'];
        $car_nombre =$_POST['nombreEst'];
        $controlador->setEstado($id, $car_nombre);
    } 
    if($_POST['Accion'] === "Crear"){
        $car_nombre =$_POST['nombreEst'];
        $controlador->crearEstado($car_nombre);
    }
}