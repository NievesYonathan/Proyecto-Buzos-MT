<?php

include_once "../Conexion.php";

class Cargo
{
    private $idCargo;
    private $cargo;
    public function __construct($idCargo, $cargo)
    {
        $this->idCargo = $idCargo;
        $this->cargo = $cargo;
    }

    public function crearCargo($carNombre)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectar();

        $sql = "INSERT INTO cargos (car_nombre) 
                VALUES (?)";
        $sql = $conectar->prepare($sql);
        $sql->bind_param("s", $carNombre);
        $sql->execute();
        $sql->close();
        $conectar->close();
    }
}