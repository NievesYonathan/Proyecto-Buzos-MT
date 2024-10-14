<?php
session_start();
include '../Modelo/ModeloTarea.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$modelo = new ModeloTarea();

// Llamar estados, operarios y producciones
$estados = $modelo->obtenerEstados();
$operarios = $modelo->obtenerOperarios();
$producciones = $modelo->obtenerProducciones();

$tareasAsignadas = [];

if (isset($_SESSION['user_id'])) {
    $num_doc = $_SESSION['user_id'];
    $tareasAsignadas = $modelo->obtenerTareasPorOperario($num_doc);
}


// Manejo de acciones
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'guardar':
            $nombre = $_POST['nombreTarea'];
            $descripcion = $_POST['descripcionTarea'];
            $estado = $_POST['estadoTarea'];
            $fechaAsignacion = $_POST['fechaAsignacion'];
            $fechaEntrega = $_POST['fechaEntrega'];
            $numDoc = $_POST['usuario'];
            $produccion = $_POST['produccion'];

            if ($modelo->crearTarea($nombre, $descripcion, $estado, $fechaAsignacion, $fechaEntrega, $numDoc, $produccion)) {
                $_SESSION['alerta'] = "Tarea creada exitosamente.";
            } else {
                $_SESSION['alerta'] = "Error al crear la tarea.";
            }
            
            header('Location: ../Perfil-Operarios/nueva-tarea.php');
            exit();

        case 'actualizar':
            if (isset($_POST['id_tarea'])) {
                $idTarea = $_POST['id_tarea'];
                $nombre = $_POST['nombreTarea'];
                $descripcion = $_POST['descripcionTarea'];
                $estado = $_POST['estadoTarea'];
                $fechaAsignacion = $_POST['fechaAsignacion'];
                $fechaEntrega = $_POST['fechaEntrega'];
                $numDoc = $_POST['usuario'];
                $produccion = $_POST['produccion'];
                
                if ($modelo->actualizarTarea($idTarea, $nombre, $descripcion, $estado, $fechaAsignacion, $fechaEntrega, $numDoc, $produccion)) {
                    $_SESSION['alerta'] = "Tarea actualizada exitosamente.";
                } else {
                    $_SESSION['alerta'] = "Error al actualizar la tarea.";
                }
        
                header('Location: ../Perfil-Operarios/lista-tareas.php');
                exit();
            }
            break;

        case 'actualizarEstado':
            if (isset($_POST['id_tarea'])) {
                $idTarea = $_POST['id_tarea'];
                $estado = $_POST['estadoTarea'];
                
                if ($modelo->actualizarEstadoTarea($idTarea, $estado)) {
                    $_SESSION['alerta'] = "Estado de la tarea actualizado exitosamente.";
                } else {
                    $_SESSION['alerta'] = "Error al actualizar el estado de la tarea.";
                }

                header('Location: ../Perfil-Operarios/vista-tar-asignadas.php');
                exit();
            }
            break;

        default:
            $_SESSION['alerta'] = "Acción no válida.";
            header('Location: ../Perfil-Operarios/vista-tar-asignadas.php');
            exit();
    }
} else {
    $_SESSION['alerta'] = "No se ha enviado ninguna acción.";
    header('Location: ../Perfil-Operarios/nueva-tarea.php');
    exit();
}
?>
