<?php
require('../conexion.php'); // Conexión a la base de datos

header('Content-Type: application/json'); // Asegura el formato JSON en la respuesta

// Verificar que se ha recibido la solicitud de eliminación
if (isset($_POST['id_producto'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_POST['id_producto']);

    // Eliminar las características del producto primero para mantener la integridad referencial
    $query_eliminar_caracteristicas = "DELETE FROM producto_caracteristica WHERE id_producto = '$id_producto'";
    mysqli_query($conexion, $query_eliminar_caracteristicas);

    // Eliminar el producto de la tabla principal
    $query_eliminar_producto = "DELETE FROM producto WHERE id_producto = '$id_producto'";
    if (mysqli_query($conexion, $query_eliminar_producto)) {
        echo json_encode(["status" => "success", "message" => "Producto eliminado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el producto: " . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID de producto no especificado."]);
}
?>
