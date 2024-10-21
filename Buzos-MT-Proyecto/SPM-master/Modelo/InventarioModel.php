<?php
class InventarioModel {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function obtenerDatosInventario() {
        $sql = "SELECT 
                    rpf.id_reg_prod_fabricados AS id_producto,
                    CONCAT(rpf.reg_pf_tipo_prenda, ' - ', rpf.reg_pf_talla, ' - ', rpf.reg_pf_color) AS nombre_producto,
                    rpf.reg_pf_cantidad AS stock_actual,
                    COALESCE(SUM(rpmp.reg_pmp_cantidad_usada), 0) AS stock_utilizado,
                    rpf.reg_pf_fecha_registro AS fecha_actualizacion
                FROM reg_pro_fabricados rpf
                LEFT JOIN reg_pro_mat_prima rpmp ON rpf.id_reg_prod_fabricados = rpmp.id_produccion
                GROUP BY rpf.id_reg_prod_fabricados, rpf.reg_pf_tipo_prenda, rpf.reg_pf_talla, rpf.reg_pf_color, rpf.reg_pf_cantidad, rpf.reg_pf_fecha_registro
                ORDER BY rpf.reg_pf_fecha_registro DESC";
        
        //log_message("SQL ejecutado: " . $sql);
        
        $resultado = $this->conexion->query($sql);
        
        if (!$resultado) {
            log_message("Error en la consulta SQL: " . $this->conexion->error);
            return [];
        }
        
        $inventario = [];
        while ($fila = $resultado->fetch_assoc()) {
            $inventario[] = $fila;
        }
        
        //log_message("Número de filas obtenidas: " . count($inventario));
                
        return $inventario;
    }
}