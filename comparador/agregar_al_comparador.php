<?php
session_start();

// Verificar que se ha enviado el id_producto
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Inicializar el comparador en la sesión si no existe
    if (!isset($_SESSION['comparador'])) {
        $_SESSION['comparador'] = [];
    }

    // Agregar el producto al comparador si no está ya en él
    if (!in_array($id_producto, $_SESSION['comparador'])) {
        $_SESSION['comparador'][] = $id_producto;
    }

    // Redirigir de vuelta a la página del producto o a la lista de productos
    header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto");
    exit();
}
