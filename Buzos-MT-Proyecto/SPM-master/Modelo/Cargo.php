<?php

include_once "Conexion.php";

class Cargo
{
    private $idCargo;
    private $cargo;
    public function __construct($idCargo = null, $cargo = null)
    {
        $this->idCargo = $idCargo;
        $this->cargo = $cargo;
    }

    public function crearCargo($carNombre)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "INSERT INTO cargos (car_nombre) 
                VALUE (?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("s", $carNombre);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

    public function getCargos()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = "SELECT * FROM cargos";
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }
}