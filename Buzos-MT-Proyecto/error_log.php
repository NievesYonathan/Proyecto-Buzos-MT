<?php
// Activar la visualización de errores en el navegador
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir una función para manejar los errores
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " - Error: [$errno] $errstr - $errfile:$errline\n";
    error_log($error_message, 3, __DIR__ . '/custom_error.log');
    echo "<pre style='color:red;'>$error_message</pre>";
}

// Establecer el manejador de errores personalizado
set_error_handler("custom_error_handler");

// Función para registrar mensajes personalizados
function log_message($message) {
    $log_message = date('Y-m-d H:i:s') . " - Log: $message\n";
    error_log($log_message, 3, __DIR__ . '/custom_error.log');
    echo "<pre style='color:blue;'>$log_message</pre>";
}