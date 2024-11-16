<?php
require('../conexion.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);

    if (isset($_POST['destacar'])) {
        $query = "UPDATE producto SET destacado = 1 WHERE id_producto = ?";
    } elseif (isset($_POST['quitar_destacado'])) {
        $query = "UPDATE producto SET destacado = 0 WHERE id_producto = ?";
    } else {
        echo "Acción no válida.";
        exit();
    }

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();

    // Redirigir de vuelta al panel de administración
    header("Location: ../creacion_productos/listar_productos.php");
    exit();
}
?>
