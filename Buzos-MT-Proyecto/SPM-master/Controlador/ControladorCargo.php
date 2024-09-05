<?php

include_once "../Modelo/Cargo.php";

class ControladorCargo
{
    public function crearCargo($carNombre)
    {
        $controladorCargo = new Cargo();
        $controladorCargo->crearCargo($carNombre);
    }
}