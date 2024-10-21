<?php
require_once '../Modelo/InventarioModel.php';
require_once '../Modelo/Conexion.php';

class InventarioController {
    private $modelo;

    public function __construct($db) {
        $this->modelo = new InventarioModel($db);
    }

    public function generarReporteInventario() {
        $datosInventario = $this->modelo->obtenerDatosInventario();

        // Asegúrate de que $datosInventario sea un array
        if (!is_array($datosInventario)) {
            $datosInventario = [];
        }

        // Pasa los datos a la vista explícitamente
        //require_once '../Informes/reporte_inventario.php';

        return $datosInventario;
    }
}

// Asegúrate de que este código esté al final del archivo
$conexion = new Conexion();
$db = $conexion->conectarse();

if (!$db) {
    log_message("Error de conexión a la base de datos: " . mysqli_connect_error());
    die("Error de conexión: No se pudo conectar a la base de datos.");
}

$inventarioController = new InventarioController($db);
$inventarioController->generarReporteInventario();