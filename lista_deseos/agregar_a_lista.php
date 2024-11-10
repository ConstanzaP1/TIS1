<?php
session_start();
include '../conexion.php';

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

if (!$conexion) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la conexión a la base de datos.']);
    exit;
}

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Debe iniciar sesión para agregar productos a la lista de deseos.']);
    exit();
}

$user_id = $_SESSION['user_id']; // Obtiene el ID del usuario de la sesión

if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $nombre_lista = 'mi_lista_deseos';

    // Verifica si el producto ya está en la lista de deseos del usuario
    $query = "SELECT * FROM lista_deseo_producto WHERE nombre_lista = ? AND id_producto = ? AND user_id = ?";
    $stmt = $conexion->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta.']);
        exit;
    }
    
    $stmt->bind_param("sii", $nombre_lista, $id_producto, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Inserta el producto en la lista de deseos si no existe
        $query = "INSERT INTO lista_deseo_producto (nombre_lista, id_producto, user_id) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error al preparar la inserción.']);
            exit;
        }

        $stmt->bind_param("sii", $nombre_lista, $id_producto, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Producto agregado a la lista de deseos.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la inserción.']);
        }
    } else {
        echo json_encode(['status' => 'exists', 'message' => 'El producto ya está en la lista de deseos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado.']);
}

$stmt->close();
$conexion->close();
?>
