<?php
include_once 'Conexion.php';

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

    public function consultarMateriasPrimas($id_produccion)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = 'SELECT p.id_produccion, GROUP_CONCAT(rMP.id_registro) AS idRegistro, GROUP_CONCAT(rMP.id_pro_materia_prima) AS id_materiaPrima, GROUP_CONCAT(rMP.reg_pmp_cantidad_usada) AS cantidadUsada 
FROM produccion p 
INNER JOIN reg_pro_mat_prima rMP ON p.id_produccion = rMP.id_produccion WHERE p.id_produccion = ?
GROUP BY p.id_produccion';
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param('i', $id_produccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conectar->close();
        return $result;
    }

    public function consultarEstadoMatPri($mpId)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();
        $sql = "SELECT m.mat_pri_estado AS id, e.nombre_estado AS estado FROM materia_prima m JOIN estados e ON m.mat_pri_estado = e.id_estados WHERE m.id_materia_prima = '$mpId'";
        $result = mysqli_query($conectar, $sql);
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
        $sql = 'UPDATE materia_prima SET mat_pri_nombre = ?, mat_pri_descripcion = ?, mat_pri_cantidad = ?, mat_pri_estado = ? WHERE id_materia_prima = ?';
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
        $sql = "SELECT nombre_estado,id_estados FROM estados WHERE Tipo_estado = 'general'";
        $result = $conectar->query($sql);
        $conectar->close();
        return $result;
    }
}
