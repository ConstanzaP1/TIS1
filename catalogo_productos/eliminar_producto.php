<?php
require('../conexion.php'); // Conexión a la base de datos
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_POST['id_producto']);

    // Desactivar restricciones de claves foráneas temporalmente
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS=0");

    // Eliminar las características relacionadas primero
    $query_eliminar_caracteristicas = "DELETE FROM producto_caracteristica WHERE id_producto = '$id_producto'";
    mysqli_query($conexion, $query_eliminar_caracteristicas);

    // Luego, intentar eliminar el producto
    $query_eliminar_producto = "DELETE FROM producto WHERE id_producto = '$id_producto'";
    $resultado_eliminacion = mysqli_query($conexion, $query_eliminar_producto);

    // Reactivar las restricciones de claves foráneas
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS=1");

    if ($resultado_eliminacion) {
        echo json_encode(["status" => "success", "message" => "Producto eliminado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el producto: " . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID de producto no especificado o método incorrecto."]);
}
?>
