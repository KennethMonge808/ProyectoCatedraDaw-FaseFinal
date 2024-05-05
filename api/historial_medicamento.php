<?php
// Establecer conexión a la base de datos
$conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

if (!$conexion) {
    echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
    exit();
}

// Obtener el historial de medicamentos ordenado por fecha de inicio
$query = "SELECT * FROM medicamentos ORDER BY fecha_inicio ASC";
$resultado = pg_query($conexion, $query);

if ($resultado) {
    $historial = array();
    while ($fila = pg_fetch_assoc($resultado)) {
        $historial[] = $fila;
    }
    echo json_encode($historial);
} else {
    echo json_encode(array("success" => false, "error" => "Error al obtener el historial de medicamentos"));
}

// Cerrar la conexión
pg_close($conexion);
?>
