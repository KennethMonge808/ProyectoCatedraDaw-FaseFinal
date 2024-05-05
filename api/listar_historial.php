<?php
// Establecer conexión a la base de datos
$conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

if (!$conexion) {
    echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos: " . pg_last_error()));
    exit();
}

// Obtener el historial de medicamentos ordenado por fecha de inicio
$query = "SELECT * FROM medicamentos ORDER BY fecha_inicio DESC";
$resultado = pg_query($conexion, $query);

if ($resultado) {
    $historial = array();
    while ($fila = pg_fetch_assoc($resultado)) {
        // Convertir fechas a formato ISO8601 para asegurar compatibilidad con JavaScript
        $fila['fecha_inicio'] = date('c', strtotime($fila['fecha_inicio']));
        $fila['fecha_fin'] = date('c', strtotime($fila['fecha_fin']));
        $historial[] = $fila;
    }
    echo json_encode($historial);
} else {
    echo json_encode(array("success" => false, "error" => "Error al ejecutar la consulta SQL: " . pg_last_error()));
}

// Cerrar la conexión
pg_close($conexion);
?>
