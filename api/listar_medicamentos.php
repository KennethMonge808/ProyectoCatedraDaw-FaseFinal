<?php
// Establecer conexión a la base de datos
$conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

if (!$conexion) {
    echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
    exit();
}

// Consulta para obtener todos los medicamentos
$query = "SELECT * FROM medicamentos";
$resultado = pg_query($conexion, $query);

if (!$resultado) {
    echo json_encode(array("success" => false, "error" => "Error al obtener los medicamentos de la base de datos"));
    exit();
}

// Convertir el resultado en un array asociativo
$medicamentos = pg_fetch_all($resultado);

// Cerrar la conexión a la base de datos
pg_close($conexion);

// Devolver los medicamentos en formato JSON
echo json_encode($medicamentos);
?>
