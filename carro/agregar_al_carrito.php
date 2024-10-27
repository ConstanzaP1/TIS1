<?php
session_start();
require_once '../conexion.php';

$id_usuario = $_POST['id_usuario'];
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];

$query = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)
          ON DUPLICATE KEY UPDATE cantidad = cantidad + ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $id_usuario, $id_producto, $cantidad, $cantidad);

if ($stmt->execute()) {
    echo "Producto agregado al carrito.";
} else {
    echo "Error al agregar el producto.";
}
$stmt->close();
$conn->close();
?>
