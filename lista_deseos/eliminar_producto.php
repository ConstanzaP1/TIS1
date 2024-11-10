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
        $stmt->execute(); // Ejecuta la eliminación
        $stmt->close();
    }
}

// Redirige a la misma página después de la eliminación
header("Location: lista_deseos.php");
exit;
?>
