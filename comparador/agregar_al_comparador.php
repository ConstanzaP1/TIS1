<?php
session_start();

// Inicializar el comparador si no existe
if (!isset($_SESSION['comparador'])) {
    $_SESSION['comparador'] = [];
}

// Respuesta inicial
$response = [
    'status' => 'error',
    'message' => 'Algo salió mal.'
];

// Verificar que se haya enviado un producto
if (isset($_POST['id_producto'])) {
    $id_producto = filter_var($_POST['id_producto'], FILTER_VALIDATE_INT);

    if ($id_producto) {
        if (!in_array($id_producto, $_SESSION['comparador'])) {
            $_SESSION['comparador'][] = $id_producto;
            $response = [
                'status' => 'success',
                'message' => 'Producto agregado al comparador.'
            ];
        } else {
            $response = [
                'status' => 'exists',
                'message' => 'El producto ya está en el comparador.'
            ];
        }
    }
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
