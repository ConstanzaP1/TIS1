<?php
session_start();

// Inicializar el comparador si no existe
if (!isset($_SESSION['comparador'])) {
    $_SESSION['comparador'] = [];
    $_SESSION['tipo_comparador'] = null; // Tipo de producto en el comparador
}

// Respuesta inicial
$response = [
    'status' => 'error',
    'message' => 'Algo salió mal.'
];

// Verificar que se haya enviado un producto
if (isset($_POST['id_producto'])) {
    require('../conexion.php');
    $id_producto = filter_var($_POST['id_producto'], FILTER_VALIDATE_INT);

    if ($id_producto) {
        // Obtener el tipo del producto de la base de datos
        $query = "SELECT tipo_producto FROM producto WHERE id_producto = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            $tipo_producto = $producto['tipo_producto'];

            // Validar si el comparador está vacío o si el tipo coincide
            if (empty($_SESSION['comparador'])) {
                // Si está vacío, agregar producto y guardar su tipo
                $_SESSION['comparador'][] = $id_producto;
                $_SESSION['tipo_comparador'] = $tipo_producto;

                $response = [
                    'status' => 'success',
                    'message' => 'Producto agregado al comparador.'
                ];
            } elseif ($_SESSION['tipo_comparador'] === $tipo_producto) {
                // Si el tipo coincide, agregar producto
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
            } else {
                // Si el tipo no coincide, rechazar
                $response = [
                    'status' => 'error',
                    'message' => 'No puedes agregar productos de diferentes categorías al comparador.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Producto no encontrado.'
            ];
        }
    }
}

// Formatear la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
