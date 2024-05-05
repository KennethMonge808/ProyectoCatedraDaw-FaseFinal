<?php
// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Establecer conexión a la base de datos
    $conexion = pg_connect("host=localhost port=5432 dbname=medicamentos user=postgres password=123123");

    if (!$conexion) {
        echo json_encode(array("success" => false, "error" => "Error de conexión a la base de datos"));
        exit();
    }

    // Verificar el tipo de solicitud
    if(isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'create':
                // Verificar si se recibieron los datos del formulario
                if(isset($_POST['nombre'], $_POST['dosis'], $_POST['horario'], $_POST['duracion'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
                    // Obtener los datos del formulario
                    $nombre = $_POST['nombre'];
                    $dosis = $_POST['dosis'];
                    $horario = $_POST['horario'];
                    $duracion = $_POST['duracion'];
                    $fecha_inicio = $_POST['fecha_inicio'];
                    $fecha_fin = $_POST['fecha_fin'];

                    // Escapar los datos para evitar inyección SQL
                    $nombre = pg_escape_string($conexion, $nombre);
                    $dosis = pg_escape_string($conexion, $dosis);
                    $horario = pg_escape_string($conexion, $horario);
                    $duracion = pg_escape_string($conexion, $duracion);
                    $fecha_inicio = pg_escape_string($conexion, $fecha_inicio);
                    $fecha_fin = pg_escape_string($conexion, $fecha_fin);

                    // Insertar el medicamento en la base de datos
                    $query = "INSERT INTO medicamentos (nombre, dosis, horario, duracion_dias, fecha_inicio, fecha_fin) VALUES ('$nombre', '$dosis', '$horario', '$duracion', '$fecha_inicio', '$fecha_fin')";
                    $resultado = pg_query($conexion, $query);

                    // Verificar si la inserción fue exitosa
                    if ($resultado) {
                        echo json_encode(array("success" => true));
                    } else {
                        echo json_encode(array("success" => false, "error" => "Error al guardar el medicamento en la base de datos"));
                    }
                } else {
                    echo json_encode(array("success" => false, "error" => "Faltan datos del formulario"));
                }
                break;
            case 'update':
                // Verificar si se recibieron los datos del formulario
                if(isset($_POST['id'], $_POST['nombre'], $_POST['dosis'], $_POST['horario'], $_POST['duracion'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
                    // Obtener los datos del formulario
                    $id = $_POST['id'];
                    $nombre = $_POST['nombre'];
                    $dosis = $_POST['dosis'];
                    $horario = $_POST['horario'];
                    $duracion = $_POST['duracion'];
                    $fecha_inicio = $_POST['fecha_inicio'];
                    $fecha_fin = $_POST['fecha_fin'];

                    // Escapar los datos para evitar inyección SQL
                    $id = pg_escape_string($conexion, $id);
                    $nombre = pg_escape_string($conexion, $nombre);
                    $dosis = pg_escape_string($conexion, $dosis);
                    $horario = pg_escape_string($conexion, $horario);
                    $duracion = pg_escape_string($conexion, $duracion);
                    $fecha_inicio = pg_escape_string($conexion, $fecha_inicio);
                    $fecha_fin = pg_escape_string($conexion, $fecha_fin);

                    // Actualizar el medicamento en la base de datos
                    $query = "UPDATE medicamentos SET nombre='$nombre', dosis='$dosis', horario='$horario', duracion_dias='$duracion', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin' WHERE id=$id";
                    $resultado = pg_query($conexion, $query);

                    // Verificar si la actualización fue exitosa
                    if ($resultado) {
                        echo json_encode(array("success" => true));
                    } else {
                        echo json_encode(array("success" => false, "error" => "Error al actualizar el medicamento en la base de datos"));
                    }
                } else {
                    echo json_encode(array("success" => false, "error" => "Faltan datos del formulario"));
                }
                break;
            case 'delete':
                // Verificar si se recibió el ID del medicamento a eliminar
                if(isset($_POST['id'])) {
                    // Obtener el ID del medicamento a eliminar
                    $id = $_POST['id'];

                    // Eliminar el medicamento de la base de datos
                    $query = "DELETE FROM medicamentos WHERE id=$id";
                    $resultado = pg_query($conexion, $query);

                    // Verificar si la eliminación fue exitosa
                    if ($resultado) {
                        echo json_encode(array("success" => true));
                    } else {
                        echo json_encode(array("success" => false, "error" => "Error al eliminar el medicamento de la base de datos"));
                    }
                } else {
                    echo json_encode(array("success" => false, "error" => "Falta el ID del medicamento a eliminar"));
                }
                break;
            default:
                echo json_encode(array("success" => false, "error" => "Acción no válida"));
                break;
        }
    } else {
        echo json_encode(array("success" => false, "error" => "Falta la acción"));
    }

    // Cerrar la conexión
    pg_close($conexion);
} else {
    echo json_encode(array("success" => false, "error" => "Método de solicitud no permitido"));
}
?>
