<?php
session_start();
include '../Modelo/ModeloTarea.php';

if (isset($_POST['accion'])) {
    $modelo = new ModeloTarea();

    switch ($_POST['accion']) {
        case 'guardar':
            $nombre = $_POST['nombreTarea'];
            $descripcion = $_POST['descripcionTarea'];
            $estado = $_POST['estadoTarea'];
            $plazo = $_POST['plazoEntrega'];

            if ($modelo->crearTarea($nombre, $descripcion, $estado, $plazo)) {
                $_SESSION['alerta'] = "Tarea creada exitosamente.";
            } else {
                $_SESSION['alerta'] = "Error al crear la tarea.";
            }
            header('Location: ../Perfil-Operarios/nueva-tarea.php');
            break;

        case 'actualizar':
            $id = $_POST['idTarea'];
            $nombre = $_POST['nombreTarea'];
            $descripcion = $_POST['descripcionTarea'];
            $estado = $_POST['estadoTarea'];
            $plazo = $_POST['plazoEntrega'];

            if ($modelo->actualizarTarea($id, $nombre, $descripcion, $estado, $plazo)) {
                $_SESSION['alerta'] = "Tarea actualizada exitosamente.";
            } else {
                $_SESSION['alerta'] = "Error al actualizar la tarea.";
            }
            header('Location: ../Perfil-Operarios/lista-tareas.php');
            break;

        case 'eliminar':
            $id = $_POST['idTarea'];

            if ($modelo->eliminarTarea($id)) {
                $_SESSION['alerta'] = "Tarea eliminada exitosamente.";
            } else {
                $_SESSION['alerta'] = "Error al eliminar la tarea.";
            }
            header('Location: ../Perfil-Operarios/lista-tareas.php');
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_tarea']) && isset($_POST['estado'])) {
    $modeloTarea = new ModeloTarea();
    $id_tarea = $_POST['id_tarea'];
    $estado = $_POST['estado'];

    if ($modeloTarea->actualizarEstadoTarea($id_tarea, $estado)) {
        header('Location: ../Perfil-Operarios/lista-tareas.php?success=1');
        exit();
    } else {
        header('Location: ../Perfil-Operarios/lista-tareas.php?error=1');
        exit();
    }
}


?>
