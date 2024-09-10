<?php
include 'Conexion.php';

class MateriaPrima{
    private $mpId;
    private $mpNombres;
    private $mpDescripcion;
    private $mpUnidadMedida;
    private $mpCantidad;
    private $mpEstado;
    private $mpFechaCompra;
    private $mpMovimento;

    public function __construct($mpId = null, $mpNombres = null, $mpDescripcion = null, $mpUnidadMedida = null, $mpCantidad = null, $mpEstado = null, $mpFechaCompra = null, $mpMovimento = null){
        $this->mpId = $mpId;
        $this->mpNombres = $mpNombres;
        $this->mpDescripcion = $mpDescripcion;
        $this->mpCantidad = $mpCantidad;
        $this->mpFechaCompra = $mpFechaCompra;
        $this->mpEstado = $mpEstado;
        $this->mpCantidad = $mpCantidad;
        $this->mpMovimento = $mpMovimento;
        $this->mpUnidadMedida = $mpUnidadMedida;
}
    public function agregarMateriaPrima($mpId,$mpNombres,$mpDescripcion){
       $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = '';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('iss', $mpId, $mpNombres, $mpDescripcion);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
}
    public function consultarMateriaPrima(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM materia_prima';        
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }
    public function cambiarEstado($mpEstado){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'INSERT INTO materia_prima (mat_pri_estado) VALUES ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("s", $mpEstado);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

}