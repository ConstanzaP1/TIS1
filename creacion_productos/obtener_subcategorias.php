<?php
require('../conexion.php'); // Conexión a la base de datos

// Verificar si se ha recibido el id_categoria
if (isset($_GET['id_categoria'])) {
    $id_categoria = $_GET['id_categoria'];

    // Consultar la categoría y la subcategoría de la tabla 'categorias'
    $query_subcategorias = "SELECT id_categoria, nombre_categoria, subcategoria 
                            FROM categorias 
                            WHERE id_categoria = ?";
    $stmt = $conexion->prepare($query_subcategorias);
    $stmt->bind_param('i', $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    // Almacenar los resultados en un array
    $subcategorias = [];
    while ($row = $result->fetch_assoc()) {
        $subcategorias[] = $row;
    }

    // Enviar los resultados como una respuesta JSON
    echo json_encode(['subcategorias' => $subcategorias]);
}

mysqli_close($conexion); // Cerrar la conexión
?>
