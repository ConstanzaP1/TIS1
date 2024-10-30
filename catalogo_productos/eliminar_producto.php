<?php
require('../conexion.php'); // Conexión a la base de datos

// Verificar que se ha recibido el ID del producto a eliminar
if (isset($_GET['id_producto'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_GET['id_producto']);

    // Eliminar las características del producto primero para mantener la integridad referencial
    $query_eliminar_caracteristicas = "DELETE FROM producto_caracteristica WHERE id_producto = '$id_producto'";
    mysqli_query($conexion, $query_eliminar_caracteristicas);

    // Eliminar el producto de la tabla principal
    $query_eliminar_producto = "DELETE FROM producto WHERE id_producto = '$id_producto'";
    if (mysqli_query($conexion, $query_eliminar_producto)) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conexion);
    }
} else {
    echo "ID de producto no especificado.";
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Botón para regresar al catálogo de productos -->
<button type="button" class="btn btn-primary" onclick="window.location.href='../index.php';">Volver al Catálogo</button>
