<?php
function crearNotificacion($tipo, $mensaje, $productoId) {
    global $conn;
    $sql = "INSERT INTO notificaciones (tipo, mensaje, producto_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $tipo, $mensaje, $productoId);
    $stmt->execute();
}

function verificarStock($productoId) {
    global $conn;
    $sql = "SELECT stock FROM producto WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stock = $result->fetch_assoc()['stock'];

    if ($stock == 0) {
        crearNotificacion('sin_stock', "El producto #$productoId se ha agotado", $productoId);
    } elseif ($stock < 10) {
        crearNotificacion('stock_bajo', "El stock del producto #$productoId es bajo ($stock unidades)", $productoId);
    }
}

function registrarCompra($productoId) {
    // Lógica para registrar la compra
    // ...

    crearNotificacion('compra', "Se ha realizado una compra del producto #$productoId", $productoId);
    verificarStock($productoId);
}
?>