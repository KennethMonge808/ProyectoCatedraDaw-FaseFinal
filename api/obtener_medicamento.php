<?php
// obtener_medicamento.php

// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Verificar si se recibió el ID del medicamento
    if(isset($_GET['id'])) {
        // Establecer conexión a la base de datos
        $conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

        if (!$conexion) {
            echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
            exit();
        }

        // Obtener el ID del medicamento
        $id = $_GET['id'];

        // Consulta para obtener el medicamento por su ID
        $query = "SELECT id, nombre, dosis, horario, duracion_dias, fecha_inicio, fecha_fin FROM medicamentos WHERE id=$id"; // Incluir los nuevos campos en la consulta
        $resultado = pg_query($conexion, $query);

        if (!$resultado) {
            echo json_encode(array("success" => false, "error" => "Error al obtener el medicamento de la base de datos"));
            exit();
        }

        // Convertir el resultado en un array asociativo
        $medicamento = pg_fetch_assoc($resultado);

        // Cerrar la conexión a la base de datos
        pg_close($conexion);

        // Devolver el medicamento en formato JSON
        echo json_encode($medicamento);
    } else {
        echo json_encode(array("success" => false, "error" => "Falta el ID del medicamento"));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Método de solicitud no permitido"));
}
?>
