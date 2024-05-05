<?php
// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Establecer conexión a la base de datos
    $conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

    if (!$conexion) {
        echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
        exit();
    }

    // Verificar si se ha enviado el formulario
    if (isset($_POST['contact'])) {
        // Verificar si todos los campos están llenos
        if (
            !empty($_POST['name']) &&
            !empty($_POST['email']) &&
            !empty($_POST['direction']) &&
            !empty($_POST['phone']) &&
            !empty($_POST['message'])
        ) {
            try {
                // Preparamos la consulta SQL
                $stmt = pg_prepare($conexion, "my_query", "INSERT INTO datos (nombre, email, direccion, telefono, mensaje) VALUES ($1, $2, $3, $4, $5)");

                // Enlazamos los parámetros y ejecutamos la consulta
                $result = pg_execute($conexion, "my_query", array($_POST['name'], $_POST['email'], $_POST['direction'], $_POST['phone'], $_POST['message']));

                // Verificamos si la inserción fue exitosa
                if ($result) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false, "error" => "Error al enviar el mensaje"));
                }
            } catch (Exception $e) {
                // Mostramos un mensaje de error
                echo json_encode(array("success" => false, "error" => "Error al enviar el mensaje: " . $e->getMessage()));
            }
        } else {
            // Mostramos un mensaje si no todos los campos están llenos
            echo json_encode(array("success" => false, "error" => "Por favor, completa todos los campos del formulario."));
        }
    }
    // Cerrar la conexión
    pg_close($conexion);
} else {
    echo json_encode(array("success" => false, "error" => "Método de solicitud no permitido"));
}
?>
