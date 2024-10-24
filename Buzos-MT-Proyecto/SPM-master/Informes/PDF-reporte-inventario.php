<?php 
/*
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de opciones
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);

// Variables PHP
$titulo = "Hola, mundo!";
$contenido = "Este es un ejemplo de cómo generar un PDF usando <strong>uwu</strong>.";

// Contenido HTML con PHP utilizando interpolación
$html = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Ejemplo de PDF con Dompdf</title>
    <style> 
        body { font-family: Arial, sans-serif; }
        h1 { color: #4CAF50; }
        p { font-size: 14px; }
    </style>
</head>
<body>
    <h1>$titulo</h1>
    <p>$contenido</p>
    <p>¡Puedes personalizar el contenido como desees!</p>
</body>
</html>
";

// Cargar el contenido HTML
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('ejemplo.pdf', ['Attachment' => false]);
?>*/
