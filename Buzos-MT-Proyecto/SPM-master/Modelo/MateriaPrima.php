<?php
include 'Conexion.php';

class MateriaPrima
{
    private $mpId;
    private $mpNombres;
    private $mpDescripcion;
    private $mpUnidadMedida;
    private $mpCantidad;
    private $mpEstado;
    private $mpFechaCompra;
    private $mpProveedor;


    public function __construct($mpId = null, $mpNombres = null, $mpDescripcion = null, $mpUnidadMedida = null, $mpCantidad = null, $mpEstado = null, $mpFechaCompra = null)
    {
        $this->mpId = $mpId;
        $this->mpNombres = $mpNombres;
        $this->mpDescripcion = $mpDescripcion;
        $this->mpCantidad = $mpCantidad;
        $this->mpFechaCompra = $mpFechaCompra;
        $this->mpEstado = $mpEstado;
        $this->mpCantidad = $mpCantidad;
        $this->mpUnidadMedida = $mpUnidadMedida;
    }
    public function agregarMateriaPrima($mpNombres, $mpDescripcion, $mpUnidadMedida, $mpCantidad, $mpEstado, $mpFechaCompra, $mpProveedor)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'INSERT INTO materia_prima (mat_pri_nombre,mat_pri_descripcion,mat_pri_unidad_medida,mat_pri_cantidad,estado_id_estado,fecha_compra_mp,proveedores_id_proveedores) VALUES 
            (?,?,?,?,?,?,?)';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('sssiisi', $mpNombres, $mpDescripcion, $mpUnidadMedida, $mpCantidad, $mpEstado, $mpFechaCompra, $mpProveedor);
        $result = $stmt->execute();
        $stmt->close();
        $conectar->close();
        return $result;
    }
    public function consultarMateriaPrima()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM materia_prima';
        $result = $conectar->query($sql);
        $conectar->close();
        return $result;
    }
    /*public function cambiarEstado($mpEstado, $mpId){
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'UPDATE materia_prima SET mat_pri_estado = ? WHERE id_materia_prima = ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('si', $mpEstado, $mpId);
        $stmt->execute();
        $stmt->close();
        $conectar->close();
    }*/

    public function actualizarMateriaPrima($mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'UPDATE materia_prima SET mat_pri_nombre = ?, mat_pri_descripcion = ?, mat_pri_cantidad = ?, estado_id_estado = ? WHERE id_materia_prima = ?';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('ssiii', $mpNombres, $mpDescripcion, $mpCantidad, $mpEstado, $mpId);
        $result = $stmt->execute();
        $stmt->close();
        $conectar->close();
        return $result;
    }
    public function consultarEstados()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT * FROM estados';
        $result = $conectar->query($sql);
        $conectar->close();
        return $result;
    }
}
