<?php
include '../conexion.php';
session_start();

if (isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $user_id = $_SESSION['user_id'];

    // Preparar y ejecutar la eliminación del producto
    $query = "DELETE FROM lista_deseo_producto WHERE id_producto = ? AND user_id = ?";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ii", $producto_id, $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error al preparar la declaración SQL.";
    }

    // Redirigir de nuevo a la lista de deseos
    header("Location: lista_deseos.php");
    exit();
} else {
    echo "ID de producto no proporcionado.";
}
?>
