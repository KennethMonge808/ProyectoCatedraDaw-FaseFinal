<?php
// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Establecer conexión a la base de datos
    $conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

    if (!$conexion) {
        echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
        exit();
    }

    // Verificar si se recibió el ID del medicamento a ocultar
    if(isset($_POST['id'])) {
        // Obtener el ID del medicamento a ocultar
        $id = $_POST['id'];

        // Ocultar el medicamento del historial
        $query = "UPDATE medicamentos SET oculto = true WHERE id=$id";
        $resultado = pg_query($conexion, $query);

        // Verificar si la actualización fue exitosa
        if ($resultado) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => "Error al ocultar el medicamento del historial: " . pg_last_error()));
        }
    } else {
        echo json_encode(array("success" => false, "error" => "Falta el ID del medicamento a ocultar"));
    }

    // Cerrar la conexión
    pg_close($conexion);
} else {
    echo json_encode(array("success" => false, "error" => "Método de solicitud no permitido"));
}
?>
