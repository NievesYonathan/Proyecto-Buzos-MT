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


    public function __construct($mpId = null, $mpNombres = null, $mpDescripcion = null, $mpUnidadMedida = null, $mpCantidad = null, $mpEstado = null, $mpFechaCompra = null){
        $this->mpId = $mpId;
        $this->mpNombres = $mpNombres;
        $this->mpDescripcion = $mpDescripcion;
        $this->mpCantidad = $mpCantidad;
        $this->mpFechaCompra = $mpFechaCompra;
        $this->mpEstado = $mpEstado;
        $this->mpCantidad = $mpCantidad;
        $this->mpUnidadMedida = $mpUnidadMedida;
}
    public function agregarMateriaPrima($mpId,$mpNombres,$mpDescripcion,$mpUnidadMedida,$mpCantidad,$mpEstado,$mpFechaCompra){
       $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'INSERT INTO materia_prima (id_materia_prima, mat_pri_nombre, mat_pri_descripcion,mat_pri_unidad_medida,mat_pri_cantidad,mat_pri_estado,fecha_compra_mp,proveedores_id_proveedores) VALUES 
        (?,?,?,?,?,?,?,?)';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('isssissi', $mpId,$mpNombres,$mpDescripcion,$mpUnidadMedida,$mpCantidad,$mpEstado,$mpFechaCompra);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
}
    public function consultarMateriaPrima(){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM materia_prima';
        $result = $conectar->query($sql);
        $conectar->close();
        return $result;
    }
    public function cambiarEstado($mpEstado, $mpId){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'UPDATE materia_prima SET mat_pri_estado = ? WHERE id_materia_prima = ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('si', $mpEstado, $mpId);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }

    public function actualizarMateriaPrima($mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId) {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'UPDATE materia_prima SET mat_pri_nombre = ?, mat_pri_descripcion = ?, mat_pri_cantidad = ?, mat_pri_estado = ? WHERE id_materia_prima = ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('ssisi', $mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }
}