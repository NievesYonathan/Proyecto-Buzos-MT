<?php
include '../Modelo/Conexion.php'; // Incluye la conexión a la base de datos

$conexion = new Conexion();
$conectarse = $conexion->conectarse();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = $_POST['query'] ?? ''; // Verifica si la consulta fue proporcionada

    if (!empty($query)) {
        $result = $conectarse->query($query);
        
        if ($result) {
            $output = ''; // Aquí construiremos el HTML
            while ($row = $result->fetch_assoc()) {
                $tipo_doc = $row['tipo_doc'] ?? 'Desconocido'; // Maneja tipo de documento
                $cargo = $row['cargo'] ?? 'Sin cargo'; // Maneja el cargo si es nulo
                
                // Construimos la fila de la tabla
                $output .= '<tr class="text-center">';
                $output .= '<td>' . $tipo_doc . '</td>';
                $output .= '<td>' . $row['num_doc'] . '</td>';
                $output .= '<td>' . $row['usu_nombres'] . '</td>';
                $output .= '<td>' . $row['usu_apellidos'] . '</td>';
                $output .= '<td>' . $row['usu_telefono'] . '</td>';
                $output .= '<td>' . $row['usu_email'] . '</td>';
                $output .= '<td>' . $cargo . '</td>';
                $output .= '</tr>';
            }
            
            // Si se encontraron resultados, los mostramos
            if (!empty($output)) {
                echo $output;
            } else {
                echo '<tr><td colspan="7">No se encontraron resultados.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="7">Error en la consulta: ' . $conectarse->error . '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="7">No se proporcionó una consulta.</td></tr>';
    }
} else {
    echo '<tr><td colspan="7">Método de solicitud no válido.</td></tr>';
}
?>
