<?php
session_start();
header('Content-Type: application/json');

// Verificar que se ha enviado el id_producto
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Inicializar el comparador en la sesión si no existe
    if (!isset($_SESSION['comparador'])) {
        $_SESSION['comparador'] = [];
    }

    // Verificar si el producto ya está en el comparador
    if (in_array($id_producto, $_SESSION['comparador'])) {
        echo json_encode(['status' => 'exists', 'message' => 'El producto ya está en el comparador.']);
    } else {
        // Agregar el producto al comparador
        $_SESSION['comparador'][] = $id_producto;
        echo json_encode(['status' => 'success', 'message' => 'Producto agregado al comparador exitosamente.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID del producto no especificado.']);
}
exit();
