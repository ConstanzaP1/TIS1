<?php
session_start();
include '../conexion.php';

if (!$conexion) {
    echo "Error en la conexión a la base de datos.";
    exit;
}

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo "Debe iniciar sesión para agregar productos a la lista de deseos.";
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
        echo "Error en la preparación de la consulta: " . $conexion->error;
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
            echo "Error al preparar la inserción: " . $conexion->error;
            exit;
        }

        $stmt->bind_param("sii", $nombre_lista, $id_producto, $user_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error al ejecutar la inserción: " . $stmt->error;
        }
    } else {
        echo "exists";
    }
} else {
    echo "ID de producto no proporcionado.";
}
function eliminarDeListaDeseos($productoId) {
    // Asume que estás usando una sesión para almacenar la lista de deseos
    session_start();

    // Verifica si la lista de deseos existe
    if (isset($_SESSION['lista_deseos'])) {
        // Filtra la lista para eliminar el producto con el ID especificado
        $_SESSION['lista_deseos'] = array_filter($_SESSION['lista_deseos'], function($producto) use ($productoId) {
            return $producto['id'] != $productoId;
        });
    }
}

$stmt->close();
$conexion->close();
?>
